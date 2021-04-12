<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNearMissReportingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('near_miss_reportings', function (Blueprint $table) {
            $table->id();
            $table->integer('d_h_r_id')->nullable();
            $table->integer('d_s_r_id')->nullable();
            $table->string('near_miss_activites');
            $table->boolean('near_miss_occurrence');
            $table->string('near_miss_remarks')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('near_miss_reportings');
    }
}
