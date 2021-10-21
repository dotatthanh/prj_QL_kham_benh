<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHealthCertificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     * Bảng giấy khám sức khỏe
     */
    public function up()
    {
        Schema::create('health_certifications', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->integer('patient_id');
            $table->integer('consulting_room_id');
            // $table->integer('medical_service_id')->nullable();
            $table->integer('user_id');
            $table->date('date');
            $table->string('code');
            $table->integer('status');
            $table->string('conclude');
            $table->string('treatment_guide');
            $table->string('suggestion');
            $table->integer('number');
            $table->integer('total_money');
            // $table->integer('parent_id');
            // $table->text('form');
            $table->integer('type');
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
        Schema::dropIfExists('health_certifications');
    }
}
