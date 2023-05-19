@extends('admin.master')

@section('title')
    Product Color
@stop
@section('page_title')
    List
@stop

@section('action_button')
    @include('admin.include.addButton',[ 'route' => route('admin.product.productColorCreate',['product_id'=> $product_id]), 'button_text' => "Create Product Color"])
    @include('admin.include.addButton',[ 'route' => route('admin.product.index'), 'button_text' => "Back To Product List"])
@stop
@section('js')
    <script src="{{ asset('admin/assets/product.js') }}"></script>
    <script src="{{ asset('admin/assets/changeStatus.js') }}"></script>
@stop
@section('content')
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h5 class="mb-4">Product Color Status</h5>
                    <span class="form-check form-switch">
                                    <input type="checkbox"
                                           href="{{route('admin.product.changeColorStatus',$_product->id)}}"
                                           class="form-check-input change-status-toggle"
                                           @if($_product->color_status ) checked @endif>
                                </span>
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
                            <caption>Product Color List</caption>
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Color</th>
                                <th>Color Gradient Status</th>
                                <th>Image</th>
                                <th>Barcode</th>
                                <th>Quantity</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($_productColors as $productColor)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $productColor?->getColorOne?->name .'-'. $productColor?->getColorTwo?->name }}</td>
                                    <td>@if($productColor?->color_gradient)
                                            <button type="button" class="btn btn-success"> Yes</button>
                                        @else
                                            <button type="button" class="btn btn-danger"> No</button>
                                        @endif</td>
                                    <td>
                                        <img src="{{ $productColor?->product_image_color_path  }}" alt="productColors">
                                    </td>
                                    <td>{{ $productColor->barcode}}</td>
                                    <td>{{ $productColor->quantity}}</td>
                                    <td>
                                        <ul class="d-flex list-unstyled mb-0">
                                            <li class="me-2">
                                                <a href="{{route('admin.product.productColorEdit',['product_id'=> $product_id ,'productColor_id' => $productColor->id ])}}">
                                                    <em class="link-icon" data-feather="edit"></em>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="delete-modal" data-bs-toggle="modal"
                                                   data-bs-target="#deleteModel"
                                                   link='{{route('admin.product.productColorDelete',['product_id'=>$product_id ,'productColor_id' =>$productColor->id ])}}'>
                                                    <em class="link-icon" data-feather="delete"></em>
                                                </a>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{--    {{ $_product->links('admin.include.pagination') }}--}}
    @include('admin.include.delete-model')
    <div class="modal fade" id="statusModel" tabindex="-1" aria-labelledby="statusModel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h5 class="modal-title" id="exampleModalLabel">Change Status </h5>
                    <p>Are you sure you want to change status ?</p>
                </div>
                <div class="modal-body">
                    {!! Form::open(['method'=>'POST','class'=>'get_link']) !!}
                    <button class="btn btn-primary continue-btn ">Yes</button>
                    <a href="javascript:void(0);" data-dismiss="modal" class="btn btn-primary cancel-btn">Cancel</a>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@stop
