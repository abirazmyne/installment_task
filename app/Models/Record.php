<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'member_id',
        'email',
        'phone',
        'address',
        'installment_amount',
        'amount',
        'penalty_amount',
        'payment_pending_amount',
        'paid',
        'due_date',
        'payment_date',
    ];

    protected $casts = [
        'due_date' => 'datetime',
        'payment_date' => 'datetime',
    ];
}
