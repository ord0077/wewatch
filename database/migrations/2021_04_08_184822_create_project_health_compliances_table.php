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
            $table->integer('daily_hse_report_id');
            $table->string('project_health_activites');
            $table->boolean('project_health_occurrence');
            $table->string('project_health_remarks')->nullable();
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
        Schema::dropIfExists('project_health_compliances');
    }
}
