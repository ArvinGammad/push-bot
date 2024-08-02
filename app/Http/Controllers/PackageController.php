<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\Package;

use Srmklive\PayPal\Facades\PayPal;
use Srmklive\PayPal\Services\PayPal as PayPalClient;


class PackageController extends Controller
{
    public function index(){
        return view('admin.packages.index');
    }

    public function createPage(){
        return view('admin.packages.create');
    }

    public function subscriptionPage(){
        $packages = Package::where('status','1')->get();
        return view('subscription-page',compact('packages'));
    }

    public function editPackage($id){
        $package = Package::find($id);
        return view('admin.packages.edit',compact('package'));
    }

    public function createAction(Request $request){
        try {
            $package = New Package();

            if(isset($request->package_id)) $package = Package::find($request->package_id);

            $integration_array = array();

            if($request->package_wordpress_unlimited) $integration_array['wordpress'] = 'unlimited';
            else $integration_array['wordpress'] = $request->package_wordpress_limit;

            $package->name = $request->package_name;
            $package->description = $request->package_description;
            $package->addon_id = '{}';
            $package->limit = json_encode($integration_array);
            $package->subscription_id = '';
            $package->plan_id = '';
            $package->credit = $request->package_credit;
            $package->seo = $request->package_seo;
            $package->image =$request->package_image;
            $package->status = '1';
            $package->validity = $request->package_validity;
            $package->price = $request->package_price;

            $package->save();

            $response = $this->paypalApiPlanCreate($package);

            return $response;
        } catch (Exception $e) {
            return response()->json([
                'status' => "failed",
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getPackageData(){
        $package = Package::get();
        return ['data'=>$package];
    }

    public function payWithPaypal(Request $request)
    {

        $payments = WhitelabelPayments::where('user_id',app('wl_global_admin_id'))->get()->first();
        $paypal = WhitelabelBundles::where('package_id',$request->id)->where('user_id',app('wl_global_admin_id'))->get()->first();

        if(!isset($payments->paypal_client_id) || !isset($payments->paypal_secret)){
            return response()->json([
                'status' => "failed",
                'message' => 'Please contact your admin!'
            ], 500);
        }

        $clientId = $payments->paypal_client_id;
        $clientSecret = $payments->paypal_secret;

        config(['paypal.live.client_id' => $clientId]);
        config(['paypal.live.client_secret' => $clientSecret]);

        $this->provider = new PayPalClient();

        $this->provider->getAccessToken();

        // Create the agreement
        try {

            $startDate = gmdate("Y-m-d\TH:i:s\Z", strtotime("+2 minutes"));

            $subscription_data = [
                "plan_id"=> $paypal->paypal_plan_id,
                "start_time"=> $startDate,
                "quantity"=> "1",
                "subscriber"=> [
                    "name"=> [
                        "given_name"=> Auth::user()->name,
                    ],
                    "email_address"=> Auth::user()->email,
                ],
                "application_context"=> [
                    "brand_name"=> app('wl_global_company_name'),
                    "locale"=> "en-US",
                    "shipping_preference"=> "SET_PROVIDED_ADDRESS",
                    "user_action"=> "SUBSCRIBE_NOW",
                    "payment_method"=> [
                        "payer_selected"=> "PAYPAL",
                        "payee_preferred"=> "IMMEDIATE_PAYMENT_REQUIRED"
                    ],
                    "return_url"=>  route('wl.payments.paypal.plan.success', ['id' => $paypal->id]),
                    "cancel_url"=>  route('wl.payments.paypal.plan.cancel', ['id' => $paypal->id])
                ]
            ];

            $subscription = $this->provider->createSubscription($subscription_data);

            $customer = WhitelabelCustomers::where('customer_id',Auth::user()->id)->get()->first();
            $customer->paypal_subscription_id = $subscription['id'];
            $customer->save();


            return response()->json([
                'status' => "success",
                'message' => "Redirect user to PayPal for approval",
                'approval_url' => $subscription['links'][0]['href']
            ], 200);

        } catch (PayPal\Exception\PayPalConnectionException $ex) {
        // Exception handling
            return response()->json([
                'status' => "failed",
                'message' => $ex->getData()
            ], 500);
        }
    }

    function paypalApiPlanCreate($package){

        $client_id = env('PAYPAL_CLIENT_ID');
        $client_secret = env('PAYPAL_CLIENT_SECRET');

        if(!isset($client_id) || !isset($client_secret)){
            return response()->json([
                'status' => "failed",
                'message' => 'Please add your paypal API credentials.'
            ], 500);
        }

        try {
            config(['paypal.live.client_id' => $client_id]);
            config(['paypal.live.client_secret' => $client_secret]);

            $this->provider = new PayPalClient();

            $this->provider->getAccessToken();

            $createdPlan = null;

            $interval = 'MONTH';
            $cycle = 60;
            if($package->validity == 'yearly'){
                $interval = 'YEAR';
                $cycle = 60;
            }

            $product_data =  [
                "name"=> $package->name. ' Product',
                "description"=> $package->name. ' Product',
                "type"=> "SERVICE",
                "category"=> "SOFTWARE",
            ];

            $request_id = $package->id.'-'.time();

            $product = $this->provider->createProduct($product_data, $request_id);

            $product_id = $product['id'];

            $plan_data = [
                "product_id" => $product_id,
                "name" => $package->name. ' Plan',
                "description" => $package->name. ' Plan',
                "status" => "ACTIVE",
                "billing_cycles" => [
                    [
                        "frequency" => [
                            "interval_unit" => $interval,
                            "interval_count" => 1
                        ],
                        "tenure_type" => "REGULAR",
                        "sequence" => 1,
                        "total_cycles"=> $cycle,
                        "pricing_scheme" => [
                            "fixed_price" => [
                                "value" => $package->price,
                                "currency_code" => "USD"
                            ]
                        ]
                    ],
                ],
                "payment_preferences" => [
                    "auto_bill_outstanding" => true,
                    "setup_fee_failure_action" => "CONTINUE",
                    "payment_failure_threshold" => 3
                ]
            ];

            $plan = $this->provider->createPlan($plan_data);

            // \Log::info("Response ", $plan);

            $planId = $plan['id'];

            $this->provider->activatePlan($planId);

            $package->plan_id = $planId;
            $package->update();

        } catch (Exception $e) {
            return response()->json([
                'status' => "failed",
                'message' => $e->getMessage()
            ], 500);
        }

            

        return response()->json([
            'status' => "success",
            'message' => "Success",
        ], 200);
    }
}
