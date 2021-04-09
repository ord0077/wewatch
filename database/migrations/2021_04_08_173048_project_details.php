<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ProjectDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_details', function (Blueprint $table) {
            $table->id();
           
            $table->integer('daily_hse_report_id');
            $table->string('weather');
            $table->string('wind_strength');
            $table->string('weather_wind_remarks')->nullable();
            $table->string('design_build_time');
            $table->string('daily_operation_man_hour');
            $table->string('design_time_hour_remarks')->nullable();
            $table->string('contractors');
            $table->integer('staff_numbers');
            $table->integer('shift_pattern');
            $table->integer('daily_man_hours');
            $table->string('type_contractors');
            $table->integer('total_man_days');
            $table->integer('total_man_hours');
            $table->integer('total_lost_work_hours');


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
        //
    }
}
