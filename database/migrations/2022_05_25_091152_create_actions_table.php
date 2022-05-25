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
        Schema::create('actions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('activity_id');
            $table->unsignedBigInteger('input_type_id')->nullable();
            $table->boolean('input_required')->default(0);
            $table->string('name');
            $table->text('description')->nullable();
            $table->integer('order_weight')->nullable();
            $table->timestamps();

            $table->foreign('activity_id')->references('id')->on('activities');
            $table->foreign('input_type_id')->references('id')->on('input_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('actions');
    }
};
