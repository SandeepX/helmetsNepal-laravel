@extends('admin.master')

@section('title')
   Customer Management
@stop
@section('page_title')
    Customer Order History Lists
@stop
@section('action_button')
    @include('admin.include.addButton',[ 'route' => route('admin.customer.customerList'), 'button_text' => "Back Customer list"])
@stop
@section('content')
    <div class="search-box p-4 bg-white rounded mb-3 box-shadow">
        <form class="forms-sample">
            <div class="row align-items-center">
                <div class="col-lg-3">
                    <h5>All Order Lists</h5>
                </div>
                <div class="col-lg-5 col-md-4">
                    <input type="text" placeholder="Search by order title" class="form-control">
                </div>
                <div class="col-lg-2 col-md-4">
                    <select class="form-select form-select-lg">
                        <option selected>Status</option>
                        <option value="1">Delivery</option>
                        <option value="2">Pending</option>
                        <option value="3">Processing</option>
                        <option value="3">Cancel</option>
                    </select>
                </div>
                <div class="col-lg-2 col-md-4">
                    <select class="form-select form-select-lg">
                        <option selected>Price</option>
                        <option value="1">10</option>
                        <option value="2">20</option>
                        <option value="3">30</option>
                    </select>
                </div>
            </div>
        </form>
    </div>
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <img class="wd-100 ht-100 rounded-circle" style="object-fit: cover" src="{{asset($_customer->profile_image_path)}}" alt="profile">
                        <div class="text-start ms-3">
                            <span class="fw-bold">Name: {{$_customer->full_name}}</span>
                            <p>{{$_customer->email}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
                                <th>Shipping Address</th>
                                <th>Phone No.</th>
                                <th class="text-center">Payment Method</th>
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
                                        <td>{{ $value->order_code }}</td>
                                        <td>{{ $value->order_date }}</td>
                                        <td>{{ $value->customer_address }}</td>
                                        <td>{{ $value->customer_phone }}</td>
                                        <td>{{ $value->payment_method_name }}</td>
                                        <td>{{ $value->total }}</td>
                                        <td class="text-center"><span class="verify">{{ $value->payment_method_name }}</span></td>
                                        <td>
                                            <ul class="d-flex list-unstyled mb-0">
                                                <li class="me-2">
                                                    <a href="{{route('admin.order.orderDetail',['order_id' =>$value->id])}}" target="_blank">
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
