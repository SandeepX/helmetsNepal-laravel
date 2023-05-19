
@extends('admin.master')

@section('title')
    All Customer Details
@stop
@section('page_title')
    Customer Details
@stop
@section('action_button')
    @include('admin.include.addButton',[ 'route' => route('admin.customer.customerList'), 'button_text' => "Back Customer list"])
@stop
@section('content')

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

                    <div class="row profile-body">
                        <div class="col-lg-4">
                            <div class="card rounded">
                                <div class="card-body">

                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <h6 class="card-title mb-0" style="align-content: center;">Customer Detail</h6>
                                    </div>

                                    <div class="mt-3">
                                        <label class="fw-bolder mb-0 text-uppercase">Customer Name:</label>
                                        <p>{{$_customer->full_name}}</p>
                                    </div>
                                    <div class="mt-3">
                                        <label class="fw-bolder mb-0 text-uppercase">Email Address:</label>
                                        <p>{{$_customer->email}}</p>
                                    </div>
                                    <div class="mt-3">
                                        <label class="fw-bolder mb-0 text-uppercase">Contact no:</label>
                                        <p>{{$_customer->primary_contact_1}}</p>
                                    </div>
                                    <div class="mt-3">
                                        <label class="fw-bolder mb-0 text-uppercase">Customer Type</label>
                                        <p>{{ucfirst($_customer->user_type)}}</p>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row profile-body">
                        <div class="col-lg-6">
                            <div class="card rounded">
                                <div class="card-body">

                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <h6 class="card-title mb-0" style="align-content: center;">Customer Address </h6>
                                    </div>

                                    <div class="mt-3">
                                        <label class="fw-bolder mb-0 text-uppercase">Address Line 1:</label>
                                        <p>{{$_customer->address_line1}}</p>
                                    </div>
                                    <div class="mt-3">
                                        <label class="fw-bolder mb-0 text-uppercase">Address Line 2:</label>
                                        <p>{{$_customer->address_line2}}</p>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card rounded">
                                <div class="card-body">

                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <h6 class="card-title mb-0" style="align-content: center;">Phone  Detail</h6>
                                    </div>
                                    <div class="row profile-body">
                                        <div class="col-lg-6">
                                            <div class="card rounded">
                                                <div class="card-body">

                                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                                        <h6 class="card-title mb-0" style="align-content: center;">Phone Number 1</h6>
                                                    </div>
                                                    <div class="mt-3">
                                                        <label class="fw-bolder mb-0 text-uppercase">Primary:</label>
                                                        <p>{{$_customer->primary_contact_1}}</p>
                                                    </div>
                                                    <div class="mt-3">
                                                        <label class="fw-bolder mb-0 text-uppercase">Secondary:</label>
                                                        <p>{{$_customer->Secondary_contact_1}}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="card rounded">
                                                <div class="card-body">

                                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                                        <h6 class="card-title mb-0" style="align-content: center;">Phone Number 2 </h6>
                                                    </div>
                                                    <div class="mt-3">
                                                        <label class="fw-bolder mb-0 text-uppercase">Primary:</label>
                                                        <p>{{$_customer->primary_contact_2}}</p>
                                                    </div>
                                                    <div class="mt-3">
                                                        <label class="fw-bolder mb-0 text-uppercase">Secondary:</label>
                                                        <p>{{$_customer->Secondary_contact_2}}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop
