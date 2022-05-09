<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Pixel;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pixels', function (Blueprint $table) {
            $table->integer('table_id');
        });

        $pixels = Pixel::get();
        foreach($pixels as $pixel) {
            Pixel::where('table_id', 0)->update(['table_id' => 1]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pixels', function (Blueprint $table) {
            $table->dropColumn('table_id');
        });
    }
};
