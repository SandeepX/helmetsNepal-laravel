@extends('admin.master')

@section('title')
    Product
@stop
@section('page_title')
    List
@stop

@section('action_button')
    @include('admin.include.addButton',[ 'route' => route('admin.product.create'), 'button_text' => "Create Product"])
@stop
@section('js')
    <script src="{{ asset('admin/assets/productIndex.js') }}"></script>
    <script src="{{ asset('admin/assets/changeStatus.js') }}"></script>
@stop
@section('content')
    <div class="search-box p-4 bg-white rounded mb-3 box-shadow">
        <form class="forms-sample" action="{{route('admin.product.index')}}" method="get">
            <div class="row align-items-center">
                <div class="col-lg-2">
                    <h5>Search</h5>
                </div>
                <div class="col-lg-4 col-md-4">
                    {!! Form::text('search', $value = Request::get('search'), ['id'=>'search','placeholder'=>'Search','class'=>'form-control']) !!}
                </div>
                <div class="col-lg-2 col-md-3">
                    {!! Form::select('category_id',$_category, $value = Request::get('category_id'), ['id'=>'category_id','class'=>'form-select','placeholder'=>'Select Category']) !!}
                </div>
                <div class="col-lg-2 col-md-3">
                    {!! Form::select('brand_id',$_brand, $value = Request::get('brand_id'), ['id'=>'brand_id','class'=>'form-select','placeholder'=>'Select Brand']) !!}
                </div>
                <div class="col-lg-1 col-md-4">
                    <button type="submit" class="btn btn-success"><em class="link-icon" data-feather="search"></em> Search</button>
                </div>
                <div class="col-lg-1 col-md-4">
                    <a href="{{route('admin.product.index')}}" class="btn btn-warning"><em class="link-icon" data-feather="reply"></em> Reset</a>
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
                            <caption>Product List</caption>
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Start date</th>
                                <th>Image</th>
                                <th>Product Name</th>
                                <th>Category</th>
                                <th>Brand</th>
                                <th>Status</th>
                                <th>Selling Price</th>
                                <th>Approved Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($_product->total() > 0)
                                @foreach($_product as $product)
                                    <tr>
                                        <td>{{ $product->product_code }}</td>
                                        <td>{{date('Y-m-d h:i A' , strtotime($product->created_at)) ?? "-" }}</td>
                                        <td>
                                            <img src="{{asset($product->product_cover_image_path)}}" alt=" {{ $product->product_code }}">
                                        </td>
                                        <td>{{ $product->title }}</td>
                                        <td>{{ $product->getCategory?->name }}</td>
                                        <td>{{ $product->getBrand?->title }}</td>
                                        <td>
                                            <span class="form-check form-switch">
                                                <input type="checkbox" href="{{route('admin.product.changeStatus',$product->id)}}" class="form-check-input change-status-toggle" @if($product->status === \App\Http\Enums\EStatus::active->value) checked @endif>
                                            </span>
                                        </td>
                                        <td>{{ $product->product_price }}</td>
                                        <td>
                                            <span class="{{(($product->is_approved)? "verify" : "cancel")}} change-approve-status-toggle" href="{{route('admin.product.changeApproveStatus',$product->id)}}">{{ (($product->is_approved)? ucfirst(\App\Http\Enums\EStatus::active->value):  ucfirst(\App\Http\Enums\EStatus::inactive->value))  }}</span>
                                        </td>
                                        <td>
                                            <ul class="d-flex list-unstyled mb-0">
                                                <li class="me-2">
                                                    <a href="{{route('admin.product.edit',['product'=>$product->id])}}">
                                                        <em class="link-icon" data-feather="edit"></em> Edit
                                                    </a>
                                                </li>
                                                <li class="me-2">
                                                    <a href="{{route('admin.product.editProductImages',['id'=>$product->id])}}" title="Product Image">
                                                        <em class="link-icon" data-feather="image"></em> Images
                                                    </a>
                                                </li>
                                                <li class="me-2">
                                                    <a href="{{route('admin.product.productDiscount',['product_id'=>$product->id])}}" >
                                                        <em class="link-icon" data-feather="dollar-sign"></em> Discount
                                                    </a>
                                                </li>
                                                <li class="me-2">
                                                    <a data-bs-toggle="modal"
                                                       data-bs-target="#tagModel" class="product-tag" product-id = "{{$product->id}}">
                                                        <em class="link-icon" data-feather="tag"></em> Tag
                                                    </a>
                                                </li>
                                                <li class="me-2">
                                                    <a href="{{route('admin.product.show',['product'=>$product->id])}}" >
                                                        <em class="link-icon" data-feather="eye"></em> Details
                                                    </a>
                                                </li>
                                                <li class="me-2">
                                                    <a href="{{route('admin.product.productColorIndex',['product_id'=>$product->id])}}" >
                                                        <em class="link-icon" data-feather="sun"></em>Product Color
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="delete-modal" data-bs-toggle="modal"
                                                       data-bs-target="#deleteModel"
                                                       link='{{route('admin.product.destroy',['product'=>$product->id])}}'>
                                                        <em class="link-icon" data-feather="delete"></em> Delete
                                                    </a>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td class="text-left" colspan="10">No data found.</td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{ $_product->links('admin.include.pagination') }}
    @include('admin.include.delete-model')
    <div class="modal fade" id="tagModel" tabindex="-1" aria-labelledby="tagModel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h5 class="modal-title">Product Tag </h5>
                </div>
                <div class="modal-body product-tag-model">

                </div>
            </div>
        </div>
    </div>
@stop
