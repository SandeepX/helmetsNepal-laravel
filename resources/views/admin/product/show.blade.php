@extends('admin.master')

@section('title')
    Product
@stop
@section('page_title')
    Product Details
@stop
@section('action_button')
    @include('admin.include.addButton',[ 'route' => route('admin.product.index'), 'button_text' => "Back Product list"])
@stop

@section('content')
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <hr>
                        <h5 class="mb-4 border-bottom">Product basic info</h5>
                        <div class="col-lg-6 mb-3">
                            <span class="fw-bold">Product Title  : {{$_product->title}}</span>

                        </div>
                        <div class="col-lg-6 mb-3">
                            <span class="fw-bold">Product Sub Title  : {{$_product->sub_title}}</span>

                        </div>
                        <div class="col-lg-6 mb-3">
                            <span class="fw-bold">Product Code  : {{$_product->product_code}}</span>

                        </div>
                        <div class="col-lg-6 mb-3">
                            <span class="fw-bold">Product Cover Image  : </span>
                            <a href="{{ $_product->product_cover_image_path  }}" target="_blank">
                                <img src="{{ $_product->product_cover_image_path  }}" alt="{{ $_product->title }}"
                                     height="100px" width="100px">
                            </a>
                        </div>
                    </div>
                    <div class="row">
                        <hr>
                        <h5 class="mb-4 border-bottom">Product category details</h5>
                        <div class="col-lg-6 mb-3">
                            <span class="fw-bold"> Category : {{$_product->getCategory?->name}}</span>

                        </div>
                        <div class="col-lg-6 mb-3">
                            <span class="fw-bold"> Brand : {{$_product->getBrand?->title}}</span>

                        </div>
                        <div class="col-lg-6 mb-3">
                            <span class="fw-bold">Product Graphic  : {{$_product->getProductGraphic?->name}}</span>

                        </div>
                        <div class="col-lg-6 mb-3">
                            <span class="fw-bold"> Product Model : {{$_product->getProductModel?->name}}</span>

                        </div>
                        <div class="col-lg-6 mb-3">
                            <span class="fw-bold"> Product Manufacture : {{$_product->geManufacture?->name}}</span>

                        </div>

                    </div>
                    <div class="row">
                        <hr>
                        <h5 class="mb-4 border-bottom">Product Price Details</h5>
                        <div class="col-lg-6 mb-3">
                            <span class="fw-bold">  Product Price : {{$_product->product_price}}</span>

                        </div>
                        <div class="col-lg-6 mb-3">
                            <span class="fw-bold">  Product Final Price : {{$_product->final_product_price}}</span>

                        </div>
                        <div class="col-lg-6 mb-3">
                            <span
                                class="fw-bold"> Discount Amount : {{$_product->product_discount['discount_amount']}}</span>

                        </div>
                        <div class="col-lg-6 mb-3">
                            <span
                                class="fw-bold"> Discount Percentage : {{$_product->product_discount['discount_percent']}}</span>

                        </div>
                    </div>
                    <div class="row">
                        <hr>
                        <h5 class="mb-4 border-bottom">Product Identification</h5>

                        <div class="col-lg-6 mb-3">
                            <span class="fw-bold">sku  : {{$_product->sku}}</span>

                        </div>
                    </div>
                    <div class="row">
                        <hr>
                        <h5 class="mb-4 border-bottom">Product Meta Details</h5>
                        <div class="col-lg-6 mb-3">
                            <span class="fw-bold">Meta Title  : {{$_product->meta_title}}</span>

                        </div>
                        <div class="col-lg-6 mb-3">
                            <span class="fw-bold">Meta Keys  : {{$_product->meta_keys}}</span>

                        </div>
                        <div class="col-lg-6 mb-3">
                            <span class="fw-bold">Meta description  : {{$_product->meta_description}}</span>

                        </div>
                        <div class="col-lg-6 mb-3">
                            <span class="fw-bold">Alternate Text : {{$_product->alternate_text}}</span>

                        </div>
                    </div>
                    <div class="row">
                        <hr>
                        <h5 class="mb-4 border-bottom">Product Details</h5>
                        <div class="col-lg-6 mb-3">
                            <span class="fw-bold">Short description  : {!! $_product->short_details !!}</span>

                        </div>
                        <div class="col-lg-6 mb-3">
                            <span class="fw-bold">Full description  : {!! $_product->details !!}</span>

                        </div>
                    </div>
                    <div class="row">
                        <hr>
                        <h5 class="mb-4 border-bottom">Product Size</h5>
                        <div class="col-lg-6 mb-3">
                            <span class="fw-bold">Product Size Status  :
                                @if($_product->size_status)
                                    <button type="button" class="btn btn-success"> Yes</button>
                                @else
                                    <button type="button" class="btn btn-danger"> No</button>
                                @endif
                            </span>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <span class="fw-bold">Size  :
                                @foreach( $_product->getProductSize as $productSize)
                                    {{$productSize->getSize?->name}} ,
                                @endforeach
                            </span>

                        </div>
                    </div>
                    <div class="row">
                        <hr>
                        <h5 class="mb-4 border-bottom">Product Color</h5>
                        <div class="col-lg-6 mb-3">
                            <span class="fw-bold">Product Color Status  :
                                @if($_product->color_status)
                                    <button type="button" class="btn btn-success"> Yes</button>
                                @else
                                    <button type="button" class="btn btn-danger"> No</button>
                                @endif
                            </span>

                        </div>
                        <div class="col-lg-12 mb-3">
                            <table id="dataTableExample" class="table">
                                <caption>Product Color List</caption>
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Color</th>
                                    <th>Color Gradient Status</th>
                                    <th>Image</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($_productColors as $productColor)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $productColor->getColorOne?->name .'-'. $productColor->getColorTwo?->name }}</td>
                                        <td>
                                            @if($productColor->color_gradient)
                                                <button type="button" class="btn btn-success"> Yes</button>
                                            @else
                                                <button type="button" class="btn btn-danger"> No</button>
                                            @endif
                                        </td>
                                        <td>
                                            <img src="{{ $productColor->product_image_color_path  }}" alt="productColors">
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <hr>
                        <h5 class="mb-4 border-bottom">Product Custom Attribute</h5>
                        <div class="col-lg-6 mb-3">
                            <span class="fw-bold">Product Color Status  :
                                @if($_product->custom_status)
                                    <button type="button" class="btn btn-success"> Yes</button>
                                @else
                                    <button type="button" class="btn btn-danger"> No</button>
                                @endif
                            </span>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <span class="fw-bold">Product Custom Attribute Title  :
                                {{$_product->getProductCustom?->product_custom_attributes}}
                            </span>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <span class="fw-bold">Product Custom Attribute Value  :
                                {{$_product->getProductCustom?->product_custom_attribute_value}}
                            </span>
                        </div>
                    </div>
                    <div class="row">
                        <hr>
                        <h5 class="mb-4 border-bottom">For vendor</h5>
                        <div class="col-lg-6 mb-3">
                            <span class="fw-bold">Product Quantity  : {{$_product->quantity}}</span>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <span class="fw-bold">Minimum Order Quantity For vendor  :
                                {{$_product->minimum_quantity}}
                            </span>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <span class="fw-bold">Product Price for vendor  : {{$_product->vendor_price}}</span>
                        </div>
                    </div>
                    <div class="row">
                        <hr>
                        <h5 class="mb-4 border-bottom">Product Images</h5>
                        <div class="col-lg-6 mb-3">
                            <div class="row">
                                <div class="row image-main d-flex align-items-center">
                                    @foreach($_productImages as $_productImage)
                                        <div class="col-lg image-item position-relative"
                                             id="image_div_{{$_productImage->id}}">
                                            <img src="{{asset($_productImage->product_image)}}" alt="product image"
                                                 class="w-100 rounded">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
