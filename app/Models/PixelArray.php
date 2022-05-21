<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PixelArray extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'label', 'data', 'is_private', 'color_selection_id'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function colorSelection() {
        return $this->belongsTo(ColorSelection::class, 'color_selection_id');
    }
}
