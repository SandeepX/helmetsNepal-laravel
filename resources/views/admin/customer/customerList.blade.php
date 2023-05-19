@extends('admin.master')

@section('title')
    All Customer Lists
@stop
@section('page_title')
    Customer List
@stop
@section('js')
    <script src="{{ asset('admin/assets/changeStatus.js') }}"></script>
@stop
@section('content')
    <div class="search-box p-4 bg-white rounded mb-3 box-shadow">
        <form class="forms-sample">
            <div class="row align-items-center">
                <div class="col-lg-3">
                    <h5>All Customer Lists</h5>
                </div>
                <div class="col-lg-6 col-md-4">
                    <input type="text" placeholder="Search by category title" class="form-control">
                </div>
                <div class="col-lg-3 col-md-4">
                    <select class="form-select form-select-lg">
                        <option selected>Show Entries</option>
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
                    <div class="table-responsive">
                        <table id="dataTableExample" class="table">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th style="width: 300px;">Image</th>
                                <th>Full Name</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Type</th>
                                <th>Verified Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($_customers->total() > 0)
                                @foreach($_customers as $_customer)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $_customer->full_name }}</td>
                                        <td>
                                            <img class="rounded-circle" style="object-fit: cover"
                                                 src="{{asset($_customer->profile_image_path)}}" alt="profile">
                                        </td>
                                        <td>{{ $_customer->primary_contact_2 }}</td>
                                        <td>{{ $_customer->email }}</td>
                                        <td>
                                            {{ ucfirst($_customer->user_type) }}
                                        </td>
                                        <td>
                                            @if( $_customer->is_verified )
                                                <span class="text-success">Verified</span>
                                            @else
                                                <span class="text-danger">Not Verified</span>
                                            @endif
                                            @if($_customer->user_type === "vendor")
                                                <span class="form-check form-switch">
                                                    <input type="checkbox" href="{{route('admin.customer.changeStatus',$_customer->id)}}"
                                                       class="form-check-input change-status-toggle"
                                                       @if($_customer->is_verified) checked @endif>
                                            </span>
                                            @endif
                                        </td>
                                        <td>
                                            <ul class="d-flex list-unstyled mb-0">
                                                <li class="me-2">
                                                    <a href="{{route('admin.customer.customerDetail',['customer_id'=>$_customer->id])}}"
                                                       title="Customer Details">
                                                        <i class="link-icon" data-feather="user-check"></i>
                                                    </a>
                                                </li>
                                                <li class="me-2">
                                                    <a href="{{route('admin.customer.customerOrderHistory',['customer_id'=>$_customer->id])}}"
                                                       title="Customer Order History">
                                                        <i class="link-icon" data-feather="shopping-cart"></i>
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
    {{ $_customers->links('admin.include.pagination') }}
@stop
