<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDailySecurityReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daily_security_reports', function (Blueprint $table) {
            $table->id();
            $table->integer('project_id');
            $table->integer('user_id');
            $table->string('daily_report_elements');
            $table->string('guard_organization');
            $table->integer('no_staff');
            $table->integer('no_incidents_daily');
            $table->integer('no_visitors');
            $table->string('inspections');
            $table->string('observations');
            $table->string('travel_security_updates');
            $table->longText('red_flag')->nullable();
            $table->string('attachments');
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
        Schema::dropIfExists('daily_security_reports');
    }
}
