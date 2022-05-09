<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pixel extends Model
{
    use HasFactory;

    protected $fillable = ['x', 'y', 'color', 'is_manual', 'user_id', 'table_id'];

    protected $hidden = [
        'is_manual',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

}
