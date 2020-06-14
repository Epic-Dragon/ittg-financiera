<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Loan;
use App\Models\Client;
use App\Exports\PaymentsExport;
use Maatwebsite\Excel\Facades\Excel;
use DB;

class Paymentscontroller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        $recursos = Loan::where('finished', 0)->orderBy('id')->get();
        
        return view('payments.index',compact('recursos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('payments.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $loan_id, $client_id)
    {
        $abonos = Payment::where('loan_id',$loan_id)->where('client_id',$client_id)
        ->where('complet',0)->orderBy('id')->get();
        $Cantidad = $request->get('Cantidad');
        foreach($abonos as $abono)
        {
           if($Cantidad > 0)
           {
                if($abono->received_amount <= 0)//cuando tengo 0 abonado
                {
                    if($Cantidad == $abono->loan->fee)
                    {
                        
                        Payment::where('id', $abono->id)->update(['received_amount' => $Cantidad, 'complet' => 1]);
                        $Cantidad = $Cantidad - $abono->loan->fee;
                    }
                    else if ($Cantidad > $abono->loan->fee)//cuano no he depositado pero tengo más del que necesito
                    {
                        Payment::where('id', $abono->id)->update(['received_amount' => $abono->loan->fee, 'complet' => 1]);
                        $Cantidad = $Cantidad - $abono->loan->fee;
                    }
                    else{
                        Payment::where('id', $abono->id)->update(['received_amount' => $Cantidad, 'complet' => 0]);
                        $Cantidad = 0;
                        
                    }
                }
                else //cuando ya tengo algo abonado
                {
                    // lo que me falta pagar = lo que debo pagar - lo que ya pague;
                    $resto = $abono->loan->fee - $abono->received_amount;
                    if($Cantidad >= $resto)
                    {
                        Payment::where('id', $abono->id)->update(['received_amount' => $abono->loan->fee, 'complet' => 1]);
                        $Cantidad = $Cantidad - $resto;
                    }
                    //con lo que estoy pagando es menor a lo que debo
                    else //if($Cantidad < $resto) //mi cantidad entrante es menor a lo que debo pagar
                    {
                        
                        //$Total = lo que ya deposite + la cantidad que viene del nuevo deposito
                        $Total = $abono->loan->received_amount + $Cantidad;
                        Payment::where('id', $abono->id)->update(['received_amount' => $Total, 'complet' => 0]);
                        $Cantidad = 0;
                    }
                }
           }
        }
        //si ya se pagaron todos los pagos, poner en finished 1
        $NumeroPagos = Loan::where('id',$loan_id)->first();
        //saber cuantos
        $PagosHechos = Payment::where('loan_id',$loan_id)->where('client_id',$client_id)->where('complet',1)->count();
        if($NumeroPagos->payments_number == $PagosHechos)
        {
            Loan::where('id', $loan_id)->update(['finished' => 1]);
        }
        return redirect()->route('payments.refresh', ['loan_id' => $loan_id, 'client_id' => $client_id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $recursos = Loan::where('id',$loan_id)->where('client_id',$client_id)->get();
        $pagos = Payment::where('loan_id',$loan_id)->where('client_id',$client_id)->get();
      
        return view('payments.create', ['recursos' => $recursos,'pagos' => $pagos]);
    }

    public function refresh($loan_id,$client_id)
    {
        $recursos = Loan::where('id',$loan_id)->where('client_id',$client_id)->get();
        $pagos = Payment::where('loan_id',$loan_id)->where('client_id',$client_id)->get();
      
        return view('payments.create', ['recursos' => $recursos,'pagos' => $pagos]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $payment = Payment::find($id);

        $payment->delete();

        return $payment;
    }

    public function export() 
    {
        return Excel::download(new PaymentsExport, 'ResumenDePagos.xlsx');
    }
}
