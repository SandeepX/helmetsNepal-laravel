@extends('admin.master')

@section('title')
    Order Management
@stop
@section('page_title')
    Order Detail
@stop
@section('action_button')
    @include('admin.include.addButton',[ 'route' => route('admin.order.returnOrderList'), 'button_text' => "Back Return Order list"])
@stop
@section('content')
    <div class="search-box p-4 bg-white rounded mb-3 box-shadow">
        <form class="forms-sample">
            <h5 class="mb-3">Order Detail</h5>
            <div class="row">
                <div class="col-lg-4">
                    <div class="orer-detail-item border rounded p-4">
                        <h6 class="border-bottom mb-3 pb-3">Customer</h6>
                        <ul class="list-unstyled mb-0">
                            <li>Name : {{$_customer->full_name}}</li>
                            <li>Mobile : {{$_customer->mobile}}</li>
                            <li>Email : {{$_customer->email}}</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="orer-detail-item border rounded p-4">
                        <h6 class="border-bottom mb-3 pb-3">Shipped To</h6>
                        <ul class="list-unstyled mb-0">
                            <li>Phone : {{$_returnOrder->customer_phone}}</li>
                            <li>Shipped address : {{$_returnOrder->customer_address}}</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="orer-detail-item border rounded p-4">
                        <h6 class="border-bottom mb-3 pb-3">Order Date</h6>
                        <ul class="list-unstyled mb-0">
                            <li>Returned Order Date : {{$_returnOrder->return_order_date}}</li>
                        </ul>
                    </div>
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

                                <th class="text-center">Order No. -
                                    <a href="{{route('admin.order.orderDetail',['order_id'=>$_returnOrder->getOrderProductDetail->getOrder->id])}}" target="_blank">
                                        {{ $_returnOrder->getOrderProductDetail->getOrder->order_code }}
                                    </a>
                                </th>
                                <th class="text-center">Order Date. - {{$_returnOrder->getOrderProductDetail->getOrder->order_date}}</th>
                                <th class="text-center">Order Status. - {{$_returnOrder->getOrderProductDetail->getOrder->delivery_status}}</th>
                                @if($_returnOrder->status !=  App\Http\Enums\EReturnOrderStatus::accepted->value)
                                <th class="text-center">
                                    <button class="btn btn-primary delete-modal" data-bs-toggle="modal" data-bs-target="#deleteModel"> Change Status</button>
                                </th>
                                @endif
                            </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="order-track mt-3 position-relative">
                        @if($_returnOrder->status ==  App\Http\Enums\EReturnOrderStatus::canceled->value)
                            <div class="row">
                                <div class="col-lg">
                                    <div class="order-track-item text-center">
                                        <div class="track-icon"><i class="link-icon" data-feather="tag"></i></div>
                                        <p>{{App\Http\Enums\EReturnOrderStatus::canceled->value}}</p>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="row">
                            <div class="col-lg">
                                <div class="order-track-item text-center">
                                    <div class="track-icon @if($_returnOrder->status !==  App\Http\Enums\EReturnOrderStatus::pending->value) track-icon1 @endif "><i class="link-icon" data-feather="tag"></i></div>
                                    <p>{{App\Http\Enums\EReturnOrderStatus::pending->value}}</p>
                                </div>
                            </div>
                                <div class="col-lg">
                                    <div class="order-track-item text-center">
                                        <div class="track-icon @if($_returnOrder->status !==  App\Http\Enums\EReturnOrderStatus::accepted->value) track-icon1 @endif "><i class="link-icon" data-feather="user-check"></i></div>
                                        <p>{{App\Http\Enums\EReturnOrderStatus::accepted->value}}</p>
                                    </div>
                                </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h5 class="text-center border-bottom mb-3 pb-3">Product Summary</h5>
                    <div class="table-responsive">
                        <table id="dataTableExample" class="table">
                            <thead>
                            <tr>
                                <th>Product Code</th>
                                <th>Product image</th>
                                <th>Product Name</th>
                                <th>Product Category</th>
                                <th>Product Brand</th>
                                <th>Product Color</th>
                                <th>Product Size</th>
                                <th>Product Custom Attribute</th>
                                <th class="text-center">Quantity</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Product Price</th>
                                <th class="text-center">Selling Price</th>
                                <th class="text-center">Amount</th>
                            </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><a href="{{route('admin.product.show',$_returnOrder->product_id)}}" target="_blank">
                                            {{$_returnOrder->getProduct->product_code}}
                                        </a>
                                    </td>
                                    <td>
                                        <img
                                            src="{{ asset($_returnOrder->getProduct->product_cover_image_path)  }}"
                                            alt="{{ $_returnOrder->getProduct->title }}">
                                    </td>
                                    <td>
                                        <a href="{{route('admin.product.show',$_returnOrder->product_id)}}" target="_blank"> {{$_returnOrder->getProduct->title}}</a>
                                    </td>
                                    <td>{{$_returnOrder->getProduct->getCategory->name}}</td>
                                    <td>{{$_returnOrder->getProduct->getBrand->title}}</td>
                                    <td>{{$_returnOrder->getOrderProductDetail?->product_color}}</td>
                                    <td>{{$_returnOrder->getOrderProductDetail?->product_size}}</td>
                                    <td>{{$_returnOrder->getOrderProductDetail?->product_custom_attributes}}
                                        - {{$_returnOrder->getOrderProductDetail?->product_custom_attribute_value}}</td>

                                    <td class="text-center">{{$_returnOrder->quantity}}</td>
                                    <td class="text-center">{{$_returnOrder->status}}</td>
                                    <td class="text-center">{{$_returnOrder->getProduct->product_price}}</td>
                                    <td class="text-center">{{$_returnOrder->product_price}}</td>
                                    <td class="text-center">{{$_returnOrder->product_price * $_returnOrder->quantity}}</td>
                                </tr>
                            <tr>
                                <td >
                                    <h4>Note</h4>
                                </td>
                                <td class="text-center">{{$_returnOrder->note}}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="deleteModel" tabindex="-1" aria-labelledby="deleteModel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h5 class="modal-title" id="exampleModalLabel">Change Return Order Status </h5>
                    <p>Are you sure?</p>
                </div>
                <div class="modal-body">
                    {!! Form::model($_returnOrder,['route'=>['admin.order.changeReturnOrderStatus',$_returnOrder->id],'method'=>'POST','id'=>'product_submit','class'=>'forms-sample']) !!}
                    <div class="row">
                        <div class="col-lg-12 mb-3">
                            <label for="title" class="form-label"> Status</label>
                            {!! Form::select('status',$_status, $value = old('status'), ['id'=>'status','class'=>'form-select','placeholder'=>'Select Status']) !!}
                            <span class="text-danger">{{ $errors->first('title') }}</span>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary"><em class="link-icon" data-feather="plus"></em> Change Status</button>
                        </div>
                    </div>
                    <button type="button" data-dismiss="modal" class="btn btn-primary cancel-btn">Cancel</button>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@stop
