<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHseReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hse_reports', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('project_id');
            $table->string('name')->nullable();
            $table->string('date')->nullable();
            $table->string('contact_no')->nullable();
            $table->longText('weather_conditions')->nullable();
            $table->longText('work_timings')->nullable();
            $table->string('workforce_size')->nullable();
            $table->longText('subcontractors')->nullable();
            $table->longText('progress_activity')->nullable();
            $table->string('session_attendees')->nullable();
            $table->longText('red_flag')->nullable();    
            $table->string('incidents')->nullable();
            $table->longText('incidents_remarks')->nullable();
            $table->string('near_misses')->nullable();
            $table->longText('near_misses_remarks')->nullable();
            $table->string('violations_noncompliance')->nullable();
            $table->longText('violations_noncompliance_remarks')->nullable();
            $table->string('first_aid')->nullable();
            $table->longText('first_aid_remarks')->nullable();
            $table->string('environment_incidents')->nullable();
            $table->longText('environment_incidents_remarks')->nullable();
            $table->string('housekeeping')->nullable();
            $table->longText('housekeeping_remarks')->nullable();
            $table->string('safety_signs')->nullable();
            $table->longText('safety_signs_remarks')->nullable();
            $table->string('work_permit')->nullable();
            $table->longText('work_permit_remarks')->nullable();
            $table->string('drums_cylinders')->nullable();
            $table->longText('drums_cylinders_remarks')->nullable();
            $table->string('safety_concerns')->nullable();
            $table->longText('safety_concerns_remarks')->nullable();
            $table->string('covid_face_mask')->nullable();
            $table->longText('covid_face_mask_remarks')->nullable();
            $table->string('covid_respiratory_hygiene')->nullable();
            $table->longText('covid_respiratory_hygiene_remarks')->nullable();
            $table->string('social_distancing')->nullable();
            $table->longText('social_distancing_remarks')->nullable();
            $table->string('cleaning_disinfecting')->nullable();
            $table->longText('cleaning_disinfecting_remarks')->nullable();
            $table->longText('attachment')->nullable();
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
        Schema::dropIfExists('hse_reports');
    }
}
