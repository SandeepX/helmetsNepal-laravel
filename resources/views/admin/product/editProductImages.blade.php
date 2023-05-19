@extends('admin.master')

@section('title')
    Product
@stop
@section('page_title')
    Product Image
@stop
@section('action_button')
    @include('admin.include.addButton',[ 'route' => route('admin.product.index'), 'button_text' => "Back Product list"])
@stop
@section('js')
    <script src="{{ asset('admin/assets/product.js') }}"></script>
@stop
@section('content')
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">$_product
                <div class="card-body">
                    <h4 class="mb-4">Update Product Image</h4>
                    {!! Form::open(['route'=>['admin.product.updateProductImages',$_product->id],'method'=>'POST','id'=>'product_submit' ,'class'=>'forms-sample','files' => true]) !!}
                    <div class="row">
                        <div class="col-md-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="mb-4">Update Product Images</h4>
                                    {!! Form::model($_product,['route'=>['admin.product.updateProductImages',$_product->id],'method'=>'POST','id'=>'product_submit','class'=>'forms-sample','files' => true]) !!}
                                        <div class="row">
                                            <h5 class="mb-4 border-bottom">Product Images</h5>
                                            <div class="col-lg-12 mb-3">
                                                <label for="product_image" class="form-label">Upload Product
                                                    Images</label>
                                                {!! Form::file('product_image[]',['id'=>'product_image','class'=>'form-control','multiple'=>'multiple']) !!}
                                            </div>

                                            <div class="row image-main d-flex align-items-center">
                                                @foreach($_productImages as $_productImage)
                                                <div class="col-lg image-item position-relative" id="image_div_{{$_productImage->id}}">
                                                    <img src="{{asset($_productImage->product_image)}}" alt="product image" class="w-100 rounded">
                                                    {!! Form::hidden('productImage_id[]', $_productImage->id, ['id'=>"productImage_id_".$_productImage->id]) !!}
                                                    <a href="#" class="remove-image" image_div_id="image_div_{{$_productImage->id}}" productImage_id ="{{$_productImage->id}}" ><i class="link-icon" data-feather="x"></i></a>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    <div class="row">
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary"><em class="link-icon"
                                                                                              data-feather="plus"></em>
                                                upload
                                            </button>
                                        </div>
                                    </div>
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@stop
