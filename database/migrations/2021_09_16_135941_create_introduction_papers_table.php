<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIntroductionPapersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     * Bảng giấy giới thiệu
     */
    public function up()
    {
        Schema::create('introduction_papers', function (Blueprint $table) {
            $table->id();
            $table->integer('medical_examiner_id');
            $table->integer('user_id');
            $table->integer('medical_service_id')->nullable();
            // $table->integer('consulting_room_id')->nullable();
            // $table->integer('type');
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
        Schema::dropIfExists('introduction_papers');
    }
}
