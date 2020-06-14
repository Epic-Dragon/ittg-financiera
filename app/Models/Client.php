<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Loan;
use App\Models\Payment;
use Carbon\Carbon;
class Client extends Model
{
    protected $fillable = [
        'name', 'phone', 'address',
    ];

    public function loan()
    {
        return $this->hasMany(Loan::class);
    }

    public function payment()
    {
        return $this->hasMany(Payment::class);
    }

    public function getFechacreaFormatAttribute()
    {
        return \Carbon\Carbon::now();
    }
    public function getFechaCalAttribute()
    {
        return \Carbon\Carbon::now();
    }

    
}