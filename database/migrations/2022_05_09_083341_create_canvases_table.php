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
        Schema::create('canvases', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->bigInteger('width');
            $table->bigInteger('height');
            $table->boolean('script_allowed');
            $table->boolean('manual_allowed');
            $table->bigInteger('user_id');
            $table->boolean('private');
            $table->string('label');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('canvases');
    }
};
