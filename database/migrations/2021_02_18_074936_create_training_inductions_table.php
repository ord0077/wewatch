<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrainingInductionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('training_inductions', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('session_type');
            $table->string('subject');
            $table->integer('no_attendees');
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
        Schema::dropIfExists('training_inductions');
    }
}
