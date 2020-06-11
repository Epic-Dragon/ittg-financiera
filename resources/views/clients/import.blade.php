@extends('layouts.app')

@section('content')
<div class="row  ">
    <div class="col-sm-8 col-md-8 col-lg-4 mx-auto">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <div class="">
                        <h3>Importar clientes</h3>
                    </div>
                    <div class="">
                        <a href="{{ route('clients.index') }}" class="btn btn-danger">Cancelar</a>
                    </div>
                </div>
            </div>
            <div class="card-body">

            <form action="{{ route('clients.import') }}"  method="post"enctype="multipart/form-data">
                            @csrf
                            @if(Session::has('message'))
                                <p>{{ Session::get(message)}} </p>
                            @endif
                            <input type="file" name="file">
                            <button type="submit" class="btn btn-primary">{{ __('Import customers')}}</button>
                        </form>



            </div>
        </div>
    </div>
</div>
@endsection
