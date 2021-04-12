<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHazardIdentifiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hazard_identifies', function (Blueprint $table) {
            $table->id();
            $table->integer('d_h_r_id')->nullable();
            $table->integer('d_s_r_id')->nullable();
            $table->string('hazard_identify_activites');
            $table->boolean('hazard_identify_occurrence');
            $table->string('hazard_identify_remarks')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hazard_identifies');
    }
}
