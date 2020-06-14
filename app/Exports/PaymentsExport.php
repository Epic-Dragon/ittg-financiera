<?php

namespace App\Exports;


use App\Models\Loan;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Illuminate\Contracts\View\View;
use App\Exports\Exportable;
class PaymentsExport implements FromView
{
    
    public function view(): view
    {
      $recursos = Loan::where('finished', 0)->orderBy('id')->get();
      return view('payments.export',['recursos' => $recursos]);
    }
}
