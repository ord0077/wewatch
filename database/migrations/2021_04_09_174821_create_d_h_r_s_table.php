<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDHRSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('d_h_r_s', function (Blueprint $table) {
             $table->id();
            $table->integer('project_id');
            $table->integer('user_id');
            $table->string('date');
            $table->longText('description_confidential')->nullable();
            $table->longText('daily_situation_summary')->nullable();
            $table->longText('project_key_meeting')->nullable();
            $table->longText('toolbox_talk')->nullable();
            $table->longText('procurement_request')->nullable();
            $table->longText('red_flag')->nullable();
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
        Schema::dropIfExists('d_h_r_s');
    }
}
