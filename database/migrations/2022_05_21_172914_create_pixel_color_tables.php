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
        Schema::create('pixel_arrays', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('label');
            $table->string('data');
            $table->boolean('is_private');
            $table->integer('user_id');
            $table->integer('color_selection_id')->nullable();
        });
        Schema::create('color_selections', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('label');
            $table->string('data');
            $table->boolean('is_private');
            $table->integer('user_id');
            $table->integer('pixel_array_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pixel_arrays');
        Schema::dropIfExists('color_selections');
    }
};
