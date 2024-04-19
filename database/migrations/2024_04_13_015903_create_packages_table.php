<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->longtext('description')->nullable();
            $table->longtext('addon_id')->nullable();
            $table->longtext('limit')->nullable();
            $table->longtext('subscription_id')->nullable();
            $table->longtext('plan_id')->nullable();
            $table->bigInteger('credit')->default(0);
            $table->bigInteger('seo')->default(0);
            $table->bigInteger('image')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('packages');
    }
};
