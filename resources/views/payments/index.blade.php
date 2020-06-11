@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <div>
                        <h3 class="mb-0">Pagos</h3>
                    </div>
                    <div>
                        <a href="{{ route('payments.create') }}" class="btn btn-primary">
                            {{ __('New Payment')}}
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">{{ __('Name') }}</th>
                            <th scope="col">{{ __('Loan Id') }}</th>
                            <th scope="col">{{ __('Number') }}</th>
                            <th scope="col">{{ __('Amount') }}</th>
                            <th scope="col">{{ __('Payment Date') }}</th>
                            <th scope="col">{{ __('Received Amount') }}</th>
                            <th scope="col" style="width: 150px">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($payments as $payment)
                        <tr>
                            <td scope="row">{{ $payment->id }}</td>
                            <td>{{ $payment->client_id }}</td>
                            <td>{{ $payment->amount }}</td>
                            <td>{{ $payment->payments_number }}</td>
                            <td>{{ $payment->fee }}</td>
                            <td>{{ $payment->ministry_date }}</td>
                            <td>{{ $payment->due_date }}</td>
                            <td>
                                <a href="" class="btn btn-outline-secondary btn-sm">
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
                            text: 'El prestamo a sido borrado',
                            icon: 'success'
                        }).then(() => {
                            window.location.href='{{ route('payments.index') }}';
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