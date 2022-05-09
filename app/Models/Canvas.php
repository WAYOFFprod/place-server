<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Canvas extends Model
{
    use HasFactory;

    protected $fillable = ['width', 'height', 'script_allowed', 'manual_allowed', 'owner', 'private', 'label'];

    protected $attributes = [
        'width' => 1000,
        'height' => 1000,
        'script_allowed' => true,
        'manual_allowed' => true,
        'private' => true,
        'label' => 'canvas'
    ];
}
