<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedicalServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     * Bảng dịch vụ khám
     */
    public function up()
    {
        Schema::create('medical_services', function (Blueprint $table) {
            $table->id();
            $table->integer('consulting_room_id');
            $table->string('name');
            $table->integer('health_insurance_price');
            $table->integer('price');
            $table->string('unit');
            $table->text('form');
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
        Schema::dropIfExists('medical_services');
    }
}
