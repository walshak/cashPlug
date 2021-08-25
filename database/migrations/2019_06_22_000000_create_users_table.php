<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone');
            $table->integer('role')->default(2);
            $table->boolean('active')->default(1);
            $table->string('refferd_by')->nullable();
            $table->string('ref_id')->nullable();
            $table->unsignedBigInteger('cur_plan')->nullable();
            $table->boolean('plan_activated')->default(false);
            $table->timestamp('plan_activated_on')->nullable();
            $table->unsignedInteger('cycle')->default(0);
            $table->timestamp('email_verified_at')->nullable();
            $table->foreign('cur_plan')->references('id')->on('plans');
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
