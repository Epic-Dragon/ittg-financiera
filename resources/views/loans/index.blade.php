@extends('layouts.app')

@section('content')
<div class="row ">
    <div class="col-md-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <div class="">
                        <h3 class="mb-0">Préstamos</h3>
                    </div>
                    <div class="">
                        <a href="{{ route('loans.create') }}" class="btn btn-primary">Nuevo Préstamo</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th >ID</th>
                            <th >Nombre</th>
                            <th >Cantidad</th>
                            <th >Número de pagos</th>
                            <th >Cuota</th>
                            <th >Fecha de Ministración </th>
                            <th >Fecha de Vencimiento </th>
                            <th >Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                       @foreach($recursos as $loan)
                            <tr>
                                <td>{{ $loan->id }}</td>
                                <td>{{ $loan->client->name }}</td>
                                <td>{{ $loan->amount }}</td>
                                <td>{{ $loan->payments_number}}</td>
                                <td>{{ $loan->fee }}</td>
                                <td>{{ $loan->ministry_date }}</td>
                                <td>{{ $loan->due_date }}</td>
                                <td>
                                    <a href="#" class="btn btn-outline-secondary btn-sm">Ver</a>
                                    <button class="btn btn-outline-danger btn-sm btn-delete" data-id="{{ $loan->id }}" >Borrar</button>
                                </td>
                            </tr>
                       @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('bottom-js')
<script>
    $('body').on('click', '.btn-delete', function(event) {
        const id = $(this).data('id');

        const options = {
        headers: { 'X-CSRF-TOKEN' : '{{ csrf_token() }}' }
        };

        Swal.fire({
            title: '¿Estás seguro?',
            text: 'No podrás revertir esta acción',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, borralo!'
        })
        .then((result) => {
            if (result.value) {
                axios.delete('{{ route('loans.index') }}/'+ id, options)  
                    .then(result => {
                        Swal.fire({
                            title: 'Borrado',
                            text: 'El prestamo ha sido borrado',
                            icon: 'success'
                        }).then(() => {
                            window.location.href='{{ route('loans.index') }}';
                        });
                    })
                    .catch(error => {
                        Swal.fire(
                            'Ocurrió un error',
                            'El prestamo no ha podido borrarse.',
                            'error'
                        );
                    });
            }
        });
    });
</script>
@endsection
