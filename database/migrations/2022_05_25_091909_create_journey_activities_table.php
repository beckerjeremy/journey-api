<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('journey_activities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('journey_id');
            $table->unsignedBigInteger('activity_id');
            $table->timestamp('started_at');
            $table->unsignedBigInteger('status_id');
            $table->timestamps();

            $table->foreign('journey_id')->references('id')->on('journeys');
            $table->foreign('activity_id')->references('id')->on('activities');
            $table->foreign('status_id')->references('id')->on('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('journey_activities');
    }
};
