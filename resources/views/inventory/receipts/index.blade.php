@extends('layouts.app', ['page' => 'Receipts', 'pageSlug' => 'receipts', 'section' => 'inventory'])

@section('content')
    @include('alerts.success')
    <div class="row">
        <div class="card ">
            <div class="card-header">
                <div class="row">
                    <div class="col-8">
                        <h4 class="card-title">Receipts</h4>
                    </div>
                    <div class="col-4 text-right">
                        <a href="{{ route('receipts.export') }}" class="btn btn-sm btn-primary">Export receipts</a>
                        <a href="{{ route('receipts.create') }}" class="btn btn-sm btn-primary">New Receipt</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="">
                    <table class="table">
                        <thead>
                            <th>Date</th>
                            <th>Title</th>
                            <th>Provider</th>
                            <th>products</th>
                            <th>Stock</th>
                            <th>Defective Stock</th>
                            <th>Status</th>
                            <th></th>
                        </thead>
                        <tbody>
                            @foreach ($receipts as $receipt)
                                <tr>
                                    <td>{{ date('d-m-y', strtotime($receipt->created_at)) }}</td>
                                    <td style="max-width: 150px;">{{ $receipt->title }}</td>
                                    <td><a href="{{ route('providers.show', $receipt->provider) }}" style="color: white; font-weight: bold;">{{ $receipt->provider->name }}</a></td>
                                    <td>{{ $receipt->products->count() }}</td>
                                    <td>{{ $receipt->products->sum('stock') }}</td>
                                    <td>{{ $receipt->products->sum('stock_defective') }}</td>
                                    <td>
                                        @if($receipt->finalized_at)
                                            <span class="text-success">FINALIZED</span>
                                        @else
                                            <span class="text-danger">TO FINALIZE</span>
                                        @endif
                                    </td>
                                    <td class="td-actions text-right">
                                        @if($receipt->finalized_at)
                                            <a href="{{ route('receipts.show', ['receipt' => $receipt]) }}" class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="View Receipt">
                                                <i class="tim-icons icon-zoom-split"></i>
                                            </a>
                                        @else
                                            <a href="{{ route('receipts.show', ['receipt' => $receipt]) }}" class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="Edit Receipt">
                                                <i class="tim-icons icon-pencil"></i>
                                            </a>
                                        @endif
                                        <form action="{{ route('receipts.destroy', $receipt) }}" method="post" class="d-inline">
                                            @csrf
                                            @method('delete')
                                            <button type="button" class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="Delete Receipt" onclick="confirm('Are you sure you want to delete this receipt?\n\nPlease check the details\nReceipt: {{ $receipt->title }}\nProvider: {{ $receipt->provider->name }}\nNumber of products: {{ $receipt->products->count() }}\nStock: {{ $receipt->products->sum('stock') }}') ? this.parentElement.submit() : ''">
                                                <i class="tim-icons icon-simple-remove"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer py-4">
                <nav class="d-flex justify-content-end" aria-label="...">
                    {{ $receipts->links() }}
                </nav>
            </div>
        </div>
    </div>
@endsection
