@extends('layouts.app', ['page' => 'Inventory Statistics', 'pageSlug' => 'istats', 'section' => 'inventory'])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Statistics by Quantity (TOP 15)</h4>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <th>ID</th>
                            <th>Category</th>
                            <th>Name</th>
                            <th>Stock</th>
                            <th>Annual Sales</th>
                            <th>Average Price</th>
                            <th>Annual Income</th>
                            <th></th>
                        </thead>
                        <tbody>
                            @foreach($soldproductsbystock as $soldproduct)
                                <tr>
                                    <td><a href="{{ route('products.show', $soldproduct->product) }}" style="color: white; font-weight: bold;">{{ $soldproduct->product_id }}</a></td>
                                    <td><a href="{{ route('categories.show', $soldproduct->product->category) }}" style="color: white; font-weight: bold;">{{ $soldproduct->product->category->name }}</a></td>
                                    <td>{{ $soldproduct->product->name }}</td>
                                    <td>{{ $soldproduct->product->stock }}</td>
                                    <td>{{ $soldproduct->total_qty }}</td>
                                    <td><span class="text-success">{{ format_money(round($soldproduct->avg_price, 2)) }}</span></td>
                                    <td><span class="text-success">{{ format_money($soldproduct->incomes) }}</span></td>
                                    <td class="td-actions text-right">
                                        <a href="{{ route('products.show', $soldproduct->product) }}" class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="More Details">
                                            <i class="tim-icons icon-zoom-split"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="card card-tasks">
                <div class="card-header">
                    <h4 class="card-title">Statistics by Income (TOP 15)</h4>
                </div>
                <div class="card-body">
                @if(count($soldproductsbyincomes) > 0)
                    <div class="table-full-width table-responsive">
                @else
                    <div class="table-full-width">
                @endif
                        <table class="table">
                            <thead>
                                <th>ID</th>
                                <th>Category</th>
                                <th>Name</th>
                                <th>Sold</th>
                                <th>Income</th>
                            </thead>
                            <tbody>
                                @foreach ($soldproductsbyincomes as $soldproduct)
                                    <tr>
                                        <td>{{ $soldproduct->product_id }}</td>
                                        <td><a href="{{ route('categories.show', $soldproduct->product->category) }}" style="color: white; font-weight: bold;">{{ $soldproduct->product->category->name }}</a></td>
                                        <td><a href="{{ route('products.show', $soldproduct->product) }}" style="color: white; font-weight: bold;">{{ $soldproduct->product->name }}</a></td>
                                        <td>{{ $soldproduct->total_qty }}</td>
                                        <td><span class="text-success">{{ format_money($soldproduct->incomes) }}</span></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-tasks">
                <div class="card-header">
                    <h4 class="card-title">Statistics by Average Price (TOP 15)</h4>
                </div>
                <div class="card-body">
                @if(count($soldproductsbyavgprice) > 0)
                    <div class="table-full-width table-responsive">
                @else
                    <div class="table-full-width">
                @endif
                        <table class="table">
                            <thead>
                                <th>ID</th>
                                <th>Category</th>
                                <th>Name</th>
                                <th>Sold</th>
                                <th>Average Price</th>
                            </thead>
                            <tbody>
                                @foreach ($soldproductsbyavgprice as $soldproduct)
                                    <tr>
                                        <td>{{ $soldproduct->product_id }}</td>
                                        <td><a href="{{ route('categories.show', $soldproduct->product->category) }}" style="color: white; font-weight: bold;">{{ $soldproduct->product->category->name }}</a></td>
                                        <td><a href="{{ route('products.show', $soldproduct->product) }}" style="color: white; font-weight: bold;">{{ $soldproduct->product->name }}</a></td>
                                        <td>{{ $soldproduct->total_qty }}</td>
                                        <td><span class="text-success">{{ format_money(round($soldproduct->avg_price, 2)) }}</span></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection