<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'client_id', 'loan_id', 'number', 'amount', 'payment_date', 'received_amount',
    ];
}
