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
        Schema::create('journey_actions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('journey_activity_id');
            $table->unsignedBigInteger('action_id');
            $table->timestamp('started_at')->nullable();
            $table->unsignedBigInteger('status_id');
            $table->unsignedBigInteger('input_id')->nullable();
            $table->timestamps();

            $table->foreign('journey_activity_id')->references('id')->on('journey_activities');
            $table->foreign('action_id')->references('id')->on('actions');
            $table->foreign('status_id')->references('id')->on('status');
            $table->foreign('input_id')->references('id')->on('inputs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('journey_actions');
    }
};
