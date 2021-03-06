@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-10 mx-auto">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <div>
                        <h3 class="mb-0">{{ __('Payments')}}</h3>
                    </div>
                    <div>
                        <a href="{{ route('payments.export') }}" class="btn btn-primary">
                            {{ __('Export Payments')}}
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <!-- tabla aca -->
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">{{ __('Name') }}</th>
                            <th scope="col">{{ __('Amount Ministered') }}</th>
                            <th scope="col">{{ __('Fee') }}</th>
                            <th scope="col">{{ __('Payments Number') }}</th>
                            <th scope="col">{{ __('Payments Made') }}</th>
                            <th scope="col">{{ __('Balance Paid') }}</th>
                            <th scope="col">{{ __('Outstanding Balance') }}</th>
                            <th scope="col" style="width: 150px">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($recursos as $payment)
                        <tr>
                            <td scope="row">{{ $payment->id}}</td>
                            <td>{{$payment->Client->name}}</td>
                            <td>{{$payment->amount}}</td>
                            <td>{{$payment->fee}}</td>
                            <td>{{$payment->payments_number}}</td>
                            <td>{{ $payment->PagosCompletados }}</td>
                            <td>{{ $payment->SaldoAbonado}}</td>
                            <td>{{ $payment->amount - $payment->SaldoAbonado }}</td>
                            <td>
                                <a href="/payments/show/{{ $payment->id }}/ {{ $payment->client_id}}" class="btn btn-outline-secondary btn-sm">
                                   Show
                                </a>
                                <button class="btn btn-outline-danger btn-sm btn-delete" data-id="{{ $payment->id }}">Delete</button>
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
<!-- seccion de boton aca -->
@section('bottom-js')
<script>
    $('body').on('click', '.btn-delete', function(event) {
        const id = $(this).data('id');
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
                axios.delete('{{ route('payments.index') }}/' + id)
                    .then(result => {
                        Swal.fire({
                            title: 'Borrado',
                            text: 'El cliente a sido borrado',
                            icon: 'success'
                        }).then(() => {
                            window.location.href='{{ route('payments.index') }}';
                        });
                    })
                    .catch(error => {
                        Swal.fire(
                            'Ocurrió un error',
                            'El cliente no ha podido borrarse.',
                            'error'
                        );
                    });

            }
        });
    });
</script>
@endsection