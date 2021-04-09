<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCovidCompliancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('covid_compliances', function (Blueprint $table) {
            $table->id();
            $table->integer('daily_hse_report_id');
            $table->string('covid_compliance_activites');
            $table->boolean('covid_compliance_occurrence');
            $table->string('covid_compliance_remarks')->nullable();
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
        Schema::dropIfExists('covid_compliances');
    }
}
