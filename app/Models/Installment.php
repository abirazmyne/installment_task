<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Installment extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id', 'amount', 'paid', 'due_date', 'payment_date', 'penalty',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}
