<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Client;
use App\Models\Payment;
class Loan extends Model
{
    protected $fillable = [
        'client_id',
        'amount',
        'payments_number',
        'fee',
        'ministry_date',
        'due_date',
        'finished', 
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function payment()
    {
        return $this->hasMany(Payment::class);
    }

    public function getPagosCompletadosAttribute()
    {
        return $this->payment()->where('complet',1)->count();
    }

    public function getSaldoAbonadoAttribute()
    {
        return $this->payment()->sum('received_amount');
    }

    public function getSaldoPendienteAttribute()
    {
        $saldoPendiente = $this->payments()->sum('amount') - $this->saldoAbonado;
        return $saldoPendiente;
    }

   

  
    
}
