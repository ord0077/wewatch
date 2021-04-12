<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectHealthCompliancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_health_compliances', function (Blueprint $table) {
            $table->id();
            $table->integer('d_h_r_id')->nullable();
            $table->integer('d_s_r_id')->nullable();
            $table->string('project_health_activites');
            $table->boolean('project_health_occurrence');
            $table->string('project_health_remarks')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('project_health_compliances');
    }
}
