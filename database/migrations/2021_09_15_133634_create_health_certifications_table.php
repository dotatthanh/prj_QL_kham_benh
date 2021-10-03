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
            $table->string('code');
            $table->integer('parent_id');
            $table->integer('user_id');
            $table->integer('status');
            $table->integer('medical_examiner_id');
            $table->integer('consulting_room_id')->nullable();
            $table->integer('medical_service_id')->nullable();
            // $table->text('form');
            $table->string('conclude');
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
