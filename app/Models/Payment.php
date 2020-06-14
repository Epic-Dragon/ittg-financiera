<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Client;
use App\Models\Loan;
class Payment extends Model
{
    protected $fillable = [
        'client_id',
        'loan_id',
        'number',
        'amount',
        'payment_date',
        'received_amount',
        'complet',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }

}
