<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Loan;
use App\Models\Client;
use App\Models\Payment;


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

     /*   $loans = Loan::with('client')->get();
        return view('loans.index',[
            'loans' => $loans
        ]); */

        $recursos = Loan::where('finished', 0)->orderBy('id')->get();
        return view('loans.index', compact('recursos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $recursos = Client::all();
        return view('loans.create',['recursos'=>$recursos]);

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
        $loan = Loan::find($id);

        $loan->delete();

        return $loan;
    }
}
