<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceVouchersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->integer('patient_id');
            $table->integer('medical_service_id')->nullable();
            $table->integer('consulting_room_id')->nullable();
            // $table->integer('amount');
            $table->integer('user_id');
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('total_money');
            $table->string('status_examination');
            $table->string('status_payment');
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
        Schema::dropIfExists('service_vouchers');
    }
}