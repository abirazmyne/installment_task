<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class penalty_setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'penalty_percentage',
        // other fields if necessary
    ];
}
