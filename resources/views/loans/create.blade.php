@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-6 mx-auto">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <div>
                        <h3 class="mb-0">{{ __('New Loan') }}</h3>
                    </div>
                    <div>
                        <a href="{{ route('loans.index') }}" class="btn btn-danger">
                            {{ __('Cancel')}}
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('loans.store') }}" method="POST">
                    @csrf
                    <div class="form-group form-row">
                        <div class="col-md-6">
                            <label for="name">{{ __('Client') }}</label>
                            <!-- <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"> -->
                            
                                <select name="client" id="cars" class="form-control @error('client') is-invalid @enderror col-md-12">
                                @foreach($loans as $Client)
                                    <option value="{{$Client->id}}">{{$Client->name}}</option>
                                @endforeach
                                </select>
                           
                                
                            @error('client')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="cantidad">{{ __('Quantity') }}</label>
                            <input type="text" name="cantidad" id="phone" placeholder="$" class="form-control @error('cantidad') is-invalid @enderror">
                            @error('cantidad')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group form-row">
                        <div class="col-md-6">
                            <label for="numeroPagos">{{ __('Payments Number') }}</label>
                            <input type="text" name="numeroPagos" id="address" class="form-control @error('numeroPagos') is-invalid @enderror">
                            @error('numeroPagos')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="cuota">{{ __('Fee') }}</label>
                            <input type="text" name="cuota" id="address" placeholder="$" class="form-control @error('cuota') is-invalid @enderror">
                            @error('cuota')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group form-row">
                        <div class="col-md-6">
                            <label for="fechaMinistry">{{ __('Ministry Date') }}</label>
                            <input type="date"  value="{{ $loans[0]->fechacrea_format->format('Y-m-d')}}" name="fechaMinistry" id="fechaMinistry"  class="form-control @error('fechaMinistry') is-invalid @enderror">
                            @error('fechaMinistry')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="fechaVencimiento">{{ __('Due Date') }}</label>
                            <input type="date" value="{{ $loans[0]->FechaCal->addDays('fechaVencimiento')->format('Y-m-d')}}" name="fechaVencimiento" id="address" class="form-control @error('fechaVencimiento') is-invalid @enderror">
                            @error('fechaVencimiento')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success btn-lg">{{ __('Create') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

