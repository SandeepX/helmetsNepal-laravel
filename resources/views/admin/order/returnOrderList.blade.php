@extends('admin.master')

@section('title')
    All Return Order Lists
@stop
@section('page_title')
    Return Order List
@stop

@section('content')
    <div class="search-box p-4 bg-white rounded mb-3 box-shadow">
        <form class="forms-sample" action="{{route('admin.order.returnOrderList')}}" method="get">
            <div class="row align-items-center">
                <div class="col-lg-3">
                    <h5>All Return Order Lists</h5>
                </div>
                <div class="col-lg-5 col-md-4">
                    {!! Form::text('search', $value = Request::get('search'), ['id'=>'search','placeholder'=>'Search','class'=>'form-control']) !!}
                </div>
                <div class="col-lg-2 col-md-4">
                    {!! Form::select('status',$_status, $value = Request::get('status'), ['id'=>'status','class'=>'form-select','placeholder'=>'Select Status']) !!}
                </div>
                <div class="col-lg-2 col-md-4">
                    <button type="submit" class="btn btn-primary"><em class="link-icon" data-feather="plus"></em> Search</button>
                </div>
            </div>
        </form>
    </div>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="dataTableExample" class="table">
                            <thead>
                            <tr>
                                <th>S.N.</th>
                                <th>Invoice No</th>
                                <th>Order Date</th>
                                <th>Customer Name</th>
                                <th>Shipping Address</th>
                                <th>Phone No.</th>
                                <th class="text-center">Total Order Amount</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Invoice</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($_order->total() > 0)
                                @foreach($_order as $value)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td><a href="{{route('admin.order.orderDetail',['order_id'=>$value->id])}}">
                                                {{ $value->getOrderProductDetail->getOrder->order_code }}
                                            </a>
                                        </td>
                                        <td>{{ $value->return_order_date }}</td>
                                        <td>{{ $value->customer_name }}</td>
                                        <td>{{ $value->customer_address }}</td>
                                        <td>{{ $value->customer_phone }}</td>
                                        <td class="text-center">{{ $value->quantity * $value->product_price }}</td>
                                        <td class="text-center">{{ $value->status }}</td>
                                        <td>
                                            <ul class="d-flex list-unstyled mb-0">
                                                <li class="me-2">
                                                    <a href="{{route('admin.order.returnOrderDetail',['return_order_id'=>$value->id])}}">
                                                        <em class="link-icon" data-feather="eye"></em>
                                                    </a>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td class="text-left" colspan="4">No data found.</td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{ $_order->links('admin.include.pagination') }}
@stop
