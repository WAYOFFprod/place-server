<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ColorSelection extends Model
{
    use HasFactory;

    protected $fillable = ['label', 'data', 'isPrivate'];

    public function user() {
        return $this->belongsTo(User::class);
    }
    public function pixelArray() {
        return $this->belongsTo(PixelArray::class);
    }
}
