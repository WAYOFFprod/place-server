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
        Schema::create('pixel_array', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('label');
            $table->string('data');
            $table->string('is_private');
            $table->integer('user_id');
            $table->integer('color_selection_id');
        });
        Schema::create('color_selection', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('label');
            $table->string('data');
            $table->string('is_private');
            $table->integer('user_id');
            $table->integer('color_selection_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pixel_array');
        Schema::dropIfExists('color_selection');
    }
};
