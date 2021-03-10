<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccidentIncidentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accident_incidents', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('project_id');
            $table->string('location');
            $table->string('reported_date');
            $table->string('reported_time');
            $table->string('category_incident');
            $table->string('type_injury');
            $table->string('type_incident');
            $table->string('other')->nullable();
            $table->string('fatality')->nullable();
            $table->string('describe_incident')->nullable();
            $table->string('immediate_action')->nullable();
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
        Schema::dropIfExists('accident_incidents');
    }
}
