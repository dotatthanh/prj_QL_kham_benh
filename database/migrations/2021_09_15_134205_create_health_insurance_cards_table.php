<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHealthInsuranceCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     * Bảng thẻ BHYT
     */
    public function up()
    {
        Schema::create('health_insurance_cards', function (Blueprint $table) {
            $table->id();
            $table->integer('medical_examiner_id');
            $table->string('code');
            $table->string('hospital');
            $table->date('use_value');
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
        Schema::dropIfExists('health_insurance_cards');
    }
}
