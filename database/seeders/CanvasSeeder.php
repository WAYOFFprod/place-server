<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Canvas;

class CanvasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Canvas::create([
            'width' => 1000,
            'height' => 1000,
            'script_allowed' => true,
            'manual_allowed' => true,
            'user_id' => 1,
            'private' => false,
            'label' => 'Anarchy canvas'
        ]);
    }
}
