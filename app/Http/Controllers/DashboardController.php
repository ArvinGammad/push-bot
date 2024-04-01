<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    public function index(){
        return view('member.dashboard');
    }

    public function maintenance(){
        return view('maintenance');
    }

    public function profilePage(){
        return view('member.profile');
    }

    public function saveProfile(Request $request){
        $request->validate([
            'profile_name' => 'required|string',
            'profile_email' => 'required|email',
        ]);

        try {
            $user = Auth::user();
            if ($request->hasFile('profile_image')) {
                $image = $request->file('profile_image');
                $imageName = time().'.'.$image->getClientOriginalExtension();
                Storage::putFileAs('public/profile/images', $image, $imageName);

                $user->picture = $imageName;
            }

            $user->name = $request->profile_name;
            $user->email = $request->profile_email;
            $user->update();

            return response()->json(['success' => true], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

        
    }

    public function changePassword(Request $request){
        $user = Auth::user();
        $validator = Validator::make($request->all(), [
            'profile_password' => [
                'required',
                function ($attribute, $value, $fail) use ($user) {
                    if (!Hash::check($value, $user->password)) {
                        return $fail("The $attribute doesn't match the current password.");
                    }
                },
            ],
            'profile_new_password' => 'required|min:8|different:profile_password',
            'profile_confirm_password' => 'required|same:profile_new_password',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }
        
        try {
            $user->password = Hash::make($request->profile_new_password);
            $user->update();

            return response()->json(['success' => true], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
