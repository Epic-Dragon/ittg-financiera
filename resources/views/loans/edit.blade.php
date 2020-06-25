@extends('layouts.app')

@section('content')
<div class="row  ">
    <div class="col-sm-8 col-md-8 col-lg-6 mx-auto">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <div class="">
                        <h3>Editar Préstamo</h3>
                    </div>
                    <div class="">
                        <a href="{{ route('loans.index') }}" class="btn btn-danger">Cancelar</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
            <form method="POST" action="{{ route('loans.update', ['id' => $loan->id]) }}">
                    @csrf
                    <div class="form-group form-row">
                        <div class="col-md-6">
                            <label for="client">Cliente</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <label class="input-group-text">#</label>
                                </div>
                                <input type="text"  readonly value="{{$loan->client->name}}" name="clientName" id="payments_number" type="text"class="form-control" @error('client_id') is-invalid @enderror>
                                <input type="hidden" value="{{$loan->client->id}}" name="client_id" id="payments_number" type="text"class="form-control @error('payments_number') is-invalid @enderror">
                                @error('amount')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="phone">Cantidad</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <label class="input-group-text">$</label>
                                  </div>
                                <input type="number" value="{{$loan->amount}}" name="amount" id="amount" type="text"class="form-control" @error('amount') is-invalid @enderror>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-row">
                        <div class="col-md-6">
                            <label for="phone">Número de pagos</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <label class="input-group-text">#</label>
                                  </div>
                                <input type="number" value="{{$loan->payments_number}}" name="payments_number" id="payments" type="text"class="form-control" @error('payments_number') is-invalid @enderror>
                                @error('amount')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="phone">Cuota</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <label class="input-group-text">$</label>
                                  </div>
                                <input type="number" value="{{$loan->fee}}" name="fee" id="fee" type="text"class="form-control" @error('fee') is-invalid @enderror>
                                @error('fee')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-row">
                        <div class="col-md-6">
                            <label for="phone">Fecha de ministración</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <label class="input-group-text">Fecha</label>
                                  </div>
                                <input type="date" value="{{$loan->ministry_date}}" name="ministry_date" id="firstDate" type="text"class="form-control" @error('ministry_date') is-invalid @enderror>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="phone">Fecha de vencimiento</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <label class="input-group-text">Fecha</label>
                                  </div>
                                <input type="date"  value="{{$loan->due_date}}" name="due_date" id="lastDate" type="text"class="form-control" @error('due_date') is-invalid @enderror>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <button type="submit" class="btn btn-success btn-lg ">Editar</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
<script>
    var noCuotas;
    var quantity;
    var pago;
    $('#payments').change(function(){
        noCuotas = $(this).val();
        var date = $("#firstDate").val();
        var realDate = moment(date, 'YYYY-MM-DD').businessAdd(noCuotas)._d
        $("#lastDate").val(moment(realDate).format("YYYY-MM-DD"));
    });
    $("#firstDate").change(function(){
        var date = $("#firstDate").val();
        var realDate = moment(date, 'YYYY-MM-DD').businessAdd(noCuotas)._d
        $("#lastDate").val(moment(realDate).format("YYYY-MM-DD"));
    });
</script>
@endsection
