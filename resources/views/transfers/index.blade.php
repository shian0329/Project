@extends('layouts.app', ['page' => 'Transfers', 'pageSlug' => 'transfers', 'section' => 'transactions'])

@section('content')
    @include('alerts.success')
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">Transfers</h4>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{ route('transfer.export') }}" class="btn btn-sm btn-primary" style="color: white;">Export Transfers Data</a>
                            <a href="{{ route('transfer.create') }}" class="btn btn-sm btn-primary">
                                Register Transfer
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead class=" text-primary">
                            <th>Date</th>
                            <th>Title</th>
                            <th>Sender Method</th>
                            <th>Receiver Method</th>
                            <th>Reference</th>
                            <th>Amount Sent</th>
                            <th>Amount Received</th>
                            <th></th>
                        </thead>
                        <tbody>
                            @foreach ($transfers as $transfer)
                                <tr>
                                    <td>{{ date('d-m-y', strtotime($transfer->created_at)) }}</td>
                                    <td style="max-width:150px">{{ $transfer->title }}</td>
                                    <td><a href="{{ route('methods.show', $transfer->sender_method) }}" style="color: white; font-weight: bold;">{{ $transfer->sender_method->name }}</a></td>
                                    <td><a href="{{ route('methods.show', $transfer->receiver_method) }}" style="color: white; font-weight: bold;">{{ $transfer->receiver_method->name }}</a></td>
                                    <td>{{ $transfer->reference }}</td>
                                    <td><span class="text-danger">${{ $transfer->sended_amount }}</span></td>
                                    <td><span class="text-success">${{ $transfer->received_amount }}</span></td>
                                    <td class="td-actions text-right">
                                        <form action="{{ route('transfer.destroy', $transfer) }}" method="post" class="d-inline">
                                            @csrf
                                            @method('delete')
                                            <button type="button" class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="Delete Transfer" onclick="confirm('Are you sure you want to delete this transfer?\n\nPlease check the details\nTransfer: {{ $transfer->title }}\nAmount sent: ${{ $transfer->sended_amount }}\nAmount received: ${{ $transfer->received_amount }}') ? this.parentElement.submit() : ''">
                                                <i class="tim-icons icon-simple-remove"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer py-4">
                    <nav class="d-flex justify-content-end" aria-label="...">
                        {{ $transfers->links() }}
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection
