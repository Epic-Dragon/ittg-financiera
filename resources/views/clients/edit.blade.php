@extends('layouts.app')

@section('content')
<div class="row  ">
    <div class="col-sm-8 col-md-8 col-lg-6 mx-auto">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <div class="">
                        <h3>Editar cliente</h3>
                    </div>
                    <div class="">
                        <a href="{{ route('clients.index') }}" class="btn btn-danger">Cancelar</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
            <form method="POST" action="{{ route('clients.update', ['id'=> $client->id]) }}">
                    @csrf
                    <div class="form-group form-row">
                        <div class=" col-md-6">
                            <label for="name">Nombre</label>
                            <input type="text" value="{{ $client->name }}" name="name" type="text" class="form-control @error('name') is-invalid @enderror">
                            @error('name')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="phone">Telefono</label>
                            <input type="text" value="{{ $client->phone }}" name="phone" type="text"class="form-control @error('phone') is-invalid @enderror">
                            @error('phone')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group form-row">
                        <div class="col-md-12">
                            <label for="address">Dirección</label>
                            <input type="text" value="{{ $client->address }}" name="address" type="text"class="form-control @error('address') is-invalid @enderror">
                            @error('address')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success btn-lg">Editar</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection
