@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <div>
                        <h3 class="mb-0">{{ __('New Payment') }}</h3>
                    </div>
                    <div>
                        <a href="{{ route('payments.index') }}" class="btn btn-danger">
                            {{ __('Cancel')}}
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body d-flex justify-content-between">
                <div class="col-md-5 mx-auto">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between">
                            </div>
                        </div>
                        <div class="card-body  justify-content-between">
                       
                            <p> <span style="font-weight: bold;">Cliente: </span>{{ $recursos[0]->client->name }}</p>
                            <p><span style="font-weight: bold;">Total Abonado: $ </span>  {{ $recursos[0]->SaldoAbonado }}</p>
                            <p style="margin-bottom:0;"><span style="font-weight: bold;">Saldo pendiente: $   </span> {{ ($recursos[0]->payments_number * $recursos[0]->fee ) - $recursos[0]->SaldoAbonado }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-5 mx-auto">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between">
                            </div>
                        </div>
                        <div class="card-body d-flex justify-content-between">
                        
                        <form action="/payments/pay/{{ $pagos[0]->loan_id}}/{{ $pagos[0]->client_id}}" method="get">
                            @csrf
                            <div class="justify-content-between">
                                <div class="">
                                    <label for="Cantidad">{{ __('Quantity') }}</label>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <input type="Cantidad"  name="Cantidad" id="Cantidad" class="form-control @error('Cantidad') is-invalid @enderror col-md-8"> 
                                    <button type="submit" class="btn btn-primary" style="margin-left:10px;">{{ __('Pay') }}</button>
                                    @error('Cantidad')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            </form>
                        </div> 
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row" style="margin-top:20px;">
    <div class="col-md-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <div>
                        <h3 class="mb-0">{{ __('Payment details')}}</h3>
                    </div>
                </div>
            </div>
            <div class="card-body">
               
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">{{ __('Payments Number')}}</th>
                            <th scope="col">{{ __('Fee') }}</th>
                            <th scope="col">{{ __('Subscriber') }}</th>
                            <th scope="col">{{ __('Payment Date') }}</th>
                            <th scope="col">{{ __('Subscriber Date') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($pagos as $pago)
                        <tr>
                            <td scope="row">{{ $pago->number }}</td>
                            <td>{{$pago->loan->fee}}</td>
                            <td>{{$pago->received_amount}}</td>
                            <td>{{$pago->payment_date}}</td>
                            <td>{{$pago->updated_at}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

