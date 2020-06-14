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
                            <th scope="col">{{ __('Ministry Date') }}</th>
                            <th scope="col">{{ __('Due Date') }}</th>

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
                            <td>{{ $payment->amount - $payment->SaldoAbonado}}</td>
                            <td>{{ $payment->ministry_date }}</td>
                            <td>{{ $payment->due_date }}</td>


                        </tr>
                        @endforeach
                    </tbody>
                </table>