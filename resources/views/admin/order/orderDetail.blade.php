@extends('admin.master')

@section('title')
    Order Management
@stop
@section('page_title')
    Order Detail
@stop
@section('action_button')
    @include('admin.include.addButton',[ 'route' => route('admin.order.orderList'), 'button_text' => "Back Order list"])
@stop
@section('content')
    <div class="search-box p-4 bg-white rounded mb-3 box-shadow">
        <form class="forms-sample">
            <h5 class="mb-3">Order Detail</h5>
            <div class="row">
                <div class="col-lg-3">
                    <div class="orer-detail-item border rounded p-4">
                        <h6 class="border-bottom mb-3 pb-3">Customer</h6>
                        <ul class="list-unstyled mb-0">
                            <li>Name : {{$_customer->full_name}}</li>
                            <li>Mobile : {{$_customer->primary_contact_1}}</li>
                            <li>Email : {{$_customer->email}}</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="orer-detail-item border rounded p-4">
                        <h6 class="border-bottom mb-3 pb-3">Shipped To</h6>
                        <ul class="list-unstyled mb-0">
                            <li>Phone : {{$_order->customer_phone}}</li>
                            <li>Shipped address : {{$_order->customer_address}}</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="orer-detail-item border rounded p-4">
                        <h6 class="border-bottom mb-3 pb-3">Payment Method</h6>
                        <ul class="list-unstyled mb-0">
                            <li>Payment Name : {{$_order->payment_method_name ?? "Cash on Delivery" }}</li>
                            <li>Payment Transaction Id : {{$_order->payment_transaction_id ?? "-" }}</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="orer-detail-item border rounded p-4">
                        <h6 class="border-bottom mb-3 pb-3">Order Date</h6>
                        <ul class="list-unstyled mb-0">
                            <li>Order Date : {{$_order->order_date}}</li>
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
                                <th class="text-center">Order No. - {{$_order->order_code}}</th>
                                @if($_order->delivery_status !=  App\Http\Enums\EDeliveryStatus::product_delivered->value)
                                    <th class="text-center">
                                        <button class="btn btn-primary " data-bs-toggle="modal"
                                                data-bs-target="#changeStatusModel"> Change Status
                                        </button>
                                    </th>
                                @endif
                                <th class="text-center">
                                    <button class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#deleteModel"> Delete Order
                                    </button>
                                </th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="order-track mt-3 position-relative">
                        @if($_order->delivery_status ===  App\Http\Enums\EDeliveryStatus::order_cancel->value)
                            <div class="row">
                                <div class="col-lg">
                                    <div class="order-track-item text-center">
                                        <div class="track-icon"><i class="link-icon" data-feather="tag"></i></div>
                                        <p>{{App\Http\Enums\EDeliveryStatus::order_cancel->value}}</p>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="row">
                                <div class="col-lg">
                                    <div class="order-track-item text-center">
                                        <div
                                            class="track-icon @if($_order->delivery_status !==  App\Http\Enums\EDeliveryStatus::pending->value) track-icon1 @endif ">
                                            <i class="link-icon" data-feather="tag"></i></div>
                                        <p>{{App\Http\Enums\EDeliveryStatus::pending->value}}</p>
                                    </div>
                                </div>
                                <div class="col-lg">
                                    <div class="order-track-item text-center">
                                        <div
                                            class="track-icon @if($_order->delivery_status !==  App\Http\Enums\EDeliveryStatus::order_confirm->value) track-icon1 @endif ">
                                            <i class="link-icon" data-feather="shopping-cart"></i></div>
                                        <p>{{App\Http\Enums\EDeliveryStatus::order_confirm->value}}</p>
                                    </div>
                                </div>
                                <div class="col-lg">
                                    <div class="order-track-item text-center">
                                        <div
                                            class="track-icon @if($_order->delivery_status !==  App\Http\Enums\EDeliveryStatus::order_processing->value) track-icon1 @endif ">
                                            <i class="link-icon" data-feather="tag"></i></div>
                                        <p>{{App\Http\Enums\EDeliveryStatus::order_processing->value}}</p>
                                    </div>
                                </div>
                                <div class="col-lg">
                                    <div class="order-track-item text-center">
                                        <div
                                            class="track-icon @if($_order->delivery_status !==  App\Http\Enums\EDeliveryStatus::product_dispatched->value) track-icon1 @endif ">
                                            <i class="link-icon" data-feather="gift"></i></div>
                                        <p>{{App\Http\Enums\EDeliveryStatus::product_dispatched->value}}</p>
                                    </div>
                                </div>
                                <div class="col-lg">
                                    <div class="order-track-item text-center">
                                        <div
                                            class="track-icon @if($_order->delivery_status !==  App\Http\Enums\EDeliveryStatus::order_delivery->value) track-icon1 @endif ">
                                            <i class="link-icon" data-feather="truck"></i></div>
                                        <p>{{App\Http\Enums\EDeliveryStatus::order_delivery->value}}</p>
                                    </div>
                                </div>
                                <div class="col-lg">
                                    <div class="order-track-item text-center">
                                        <div
                                            class="track-icon @if($_order->delivery_status !==  App\Http\Enums\EDeliveryStatus::product_delivered->value) track-icon1 @endif ">
                                            <i class="link-icon" data-feather="user-check"></i></div>
                                        <p>{{App\Http\Enums\EDeliveryStatus::product_delivered->value}}</p>
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
                                <th>S.N.</th>
                                <th>Product Code</th>
                                <th>Product image</th>
                                <th>Product Name</th>
                                <th>Product Category</th>
                                <th>Product Brand</th>
                                <th>Product Color</th>
                                <th>Product Size</th>
                                <th>Product Custom</th>
                                <th class="text-center">Quantity</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Product Price</th>
                                <th class="text-center">Selling Price</th>
                                <th class="text-center">Amount</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($_orderProductDetails as $_orderProductDetail)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td><a href="{{route('admin.product.show',$_orderProductDetail->product_id)}}"
                                           target="_blank">
                                            {{$_orderProductDetail->product_code}}
                                        </a>
                                    </td>
                                    <td>
                                        <img
                                            src="{{ asset('/front/uploads/product_cover_image/'.$_orderProductDetail->cover_image)  }}"
                                            alt="{{ $_orderProductDetail->product_title }}">
                                    </td>
                                    <td>
                                        <a href="{{route('admin.product.show',$_orderProductDetail->product_id)}}"
                                           target="_blank"> {{$_orderProductDetail->product_title}}</a>
                                    </td>
                                    <td>{{$_orderProductDetail->category_name}}</td>
                                    <td>{{$_orderProductDetail->brand_title}}</td>
                                    <td>{{$_orderProductDetail->product_color}}</td>
                                    <td>{{$_orderProductDetail->product_size}}</td>
                                    <td>{{$_orderProductDetail->product_custom_attributes}}
                                        -> {{$_orderProductDetail->product_custom_attribute_value}}</td>

                                    <td class="text-center">{{$_orderProductDetail->quantity}}</td>
                                    <td class="text-center">{{$_orderProductDetail->status}}</td>
                                    <td class="text-center">{{$_orderProductDetail->product_price}}</td>
                                    <td class="text-center">{{$_orderProductDetail->order_product_price}}</td>
                                    <td class="text-center">{{$_orderProductDetail->total}}</td>
                                </tr>

                            @endforeach
                            <tr>
                                <td colspan="12"></td>
                                <td class="text-center">
                                    <strong>Subtotal</strong>
                                </td>
                                <td class="text-center">{{$_order->sub_total}}</td>
                            </tr>
                            <tr>
                                <td colspan="12"></td>
                                <td class="text-center">
                                    <strong>Coupon</strong>
                                </td>
                                <td class="text-center">{{$_order->coupon_code}}</td>
                            </tr>
                            <tr>
                                <td colspan="12"></td>
                                <td class="text-center">
                                    <strong>Discount</strong>
                                </td>
                                <td class="text-center">{{$_order->discount}}</td>
                            </tr>
                            <tr>
                                <td colspan="12"></td>
                                <td class="text-center">
                                    <strong>Delivery Charge Amount</strong>
                                </td>
                                <td class="text-center">
                                    {{$_order->deliveryCharge_amount}}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="12"></td>
                                <td class="text-center">
                                    <strong>Total</strong>
                                </td>
                                <td class="text-center">
                                    <strong>{{$_order->total}}</strong>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="changeStatusModel" tabindex="-1" aria-labelledby="changeStatusModel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h5 class="modal-title" id="exampleModalLabel">Change Order Status </h5>
                    <p>Are you sure?</p>
                </div>
                <div class="modal-body">
                    {!! Form::model($_order,['route'=>['admin.order.changeOrderStatus',$_order->id],'method'=>'POST','id'=>'product_submit','class'=>'forms-sample']) !!}
                    <div class="row">
                        <div class="col-lg-12 mb-3">
                            <label for="title" class="form-label"> Status</label>
                            {!! Form::select('delivery_status',$_delivery_status, $value = old('delivery_status'), ['id'=>'delivery_status','class'=>'form-select','placeholder'=>'Select Status']) !!}
                            <span class="text-danger">{{ $errors->first('title') }}</span>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary"><em class="link-icon"
                                                                              data-feather="plus"></em> Change Status
                            </button>
                        </div>
                    </div>
                    <button type="button" data-dismiss="modal" class="btn btn-primary cancel-btn">Cancel</button>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="deleteModel" tabindex="-1" aria-labelledby="deleteModel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h5 class="modal-title" id="exampleModalLabel">Delete Order</h5>
                    <p>Are you sure?</p>
                </div>
                <div class="modal-body">
                    {!! Form::open(['method'=>'DELETE','route'=>['admin.order.deleteOrder',['order_id'=>$_order->id]]]) !!}
                    <button class="btn btn-primary continue-btn ">Delete Order</button>
                    <a href="javascript:void(0);" data-dismiss="modal" class="btn btn-primary cancel-btn">Cancel</a>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@stop
