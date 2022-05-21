<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PixelArray extends Model
{
    use HasFactory;

    protected $fillable = ['label', 'data', 'is_private'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function colorSelection() {
        return $this->belongsTo(ColorSelection::class);
    }
}
