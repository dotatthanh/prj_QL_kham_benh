<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedicalExaminersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     * Bảng người khám bệnh (bệnh nhân)
     */
    public function up()
    {
        Schema::create('medical_examiners', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('name');
            $table->string('sex');
            $table->string('address');
            $table->date('birthday');
            $table->integer('id_card');
            $table->date('date_of_issue');
            $table->date('issued_by');
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
        Schema::dropIfExists('medical_examiners');
    }
}
