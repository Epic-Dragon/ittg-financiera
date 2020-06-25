<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Loan;
use App\Models\Client;
use App\Models\Payment;
use Carbon\Carbon;


class LoansController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $loans = Loan::with('client')->get();
        return view('loans.index',[
            'loans' => $loans
        ]); 

        /* $loans = Loan::where('finished', 0)->orderBy('id')->get();
        return view('loans.index', compact('loans'));*/
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $loans = Client::all();
        return view('loans.create',['loans'=>$loans]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $numeroPagos = (int) $request->get('numeroPagos');
        $fp =  $request->get('fechaMinistry');
        $fecha1 = date_create($fp);
        $request->validate([
            'client'  => 'required',
            'cantidad' => 'required|numeric',
            'numeroPagos' => 'required|numeric',
            'cuota'  => 'required|numeric',
            'fechaMinistry' => 'required|date',
            'fechaVencimiento' => 'required|date',
        ]);
       $Loan= Loan::create([
            'client_id'  => $request->input('client'),
            'amount' => $request->input('cantidad'),
            'payments_number' => $request->input('numeroPagos'),
            'fee'  => $request->input('cuota'),
            'ministry_date' => $request->input('fechaMinistry'),
            'due_date' => $request->input('fechaVencimiento'),
            'received_amount' => 0,
            'finished' => 0,
        ]);
        $id = $Loan->id;
        for ($i = 1; $i <= $numeroPagos; $i++) {
            $dias = (int) 0;
            $dias++;
            $fecha2 = date_add($fecha1, date_interval_create_from_date_string($dias." days"));
            
            Payment::create([
                'client_id'  => $request->input('client'),
                'loan_id' => $id,
                'number' => $i,
                'amount' => $request->input('cantidad'),
                'payment_date' =>  $fecha2,
                'received_amount' => 0,
                'complet' => 0,
                ]);
        }
        return redirect()->route('loans.index');
           
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $loan = Loan::with('client')->find($id);
        return view('loans.edit', [
            'loan' => $loan,
        ]);
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
        $request->validate([
            'client_id' => 'required',
            'amount' => 'required',
            'payments_number' => 'required',
            'fee' => 'required',
            'ministry_date' => 'required',
            'due_date' => 'required',
        ]);

        $loan = Loan::find($id);
        $saldoAbonado = $loan->saldoAbonado;
       
        if( $saldoAbonado > 0){
            return redirect()->route('loans.index')
                ->withError('No se puede editar por que tiene pagos registrados');
        }
        else{ //Editar el prestamo

            $loan->client_id = $request->client_id;
            $loan->amount = $request->amount;
            $loan->payments_number = $request->payments_number;
            $loan->fee = $request->fee;
            $loan->ministry_date = $request->ministry_date;
            $loan->due_date = $request->due_date;
            $loan->finished = 0;
            $loan->save();

            //Borrar payments
            Payment::where('loan_id',$id)->delete();

            $date = Carbon::createFromDate($loan->ministry_date); //Guarda la fecha en la varible date
            $count = 0;
            while($count < $loan->payments_number)
            {
                $date->addDay(); //Incrementa un día a la fecha date
                if($date->isWeekday()) //Verifica si date es día de semana
                {
                    $payment = new Payment();
                    $payment->client_id = $loan->client_id;
                    $payment->loan_id = $loan->id;
                    $payment->number = $count+1;
                    $payment->amount = $loan->fee;
                    $payment->received_amount = 0;
                    $payment->payment_date = $date;
                    $payment->save();
                    $count++;
                }
            }
            return redirect()->route('loans.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $loan = Loan::find($id);
        foreach($loan->payments as $payment)
        {
            $payment->delete();
        }
        $loan->delete();
    }
}
