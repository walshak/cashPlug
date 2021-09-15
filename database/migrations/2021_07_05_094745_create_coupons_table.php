<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('coupon');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('vendor');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('plan_id');
            $table->boolean('used')->default(false);
            $table->timestamp('used_on')->nullable();
            $table->foreign('plan_id')->references('id')->on('plans');
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('vendor')->references('id')->on('users');
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('coupons');
    }
}
