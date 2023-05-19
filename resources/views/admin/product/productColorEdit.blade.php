@extends('admin.master')

@section('title')
    Product Color
@stop
@section('page_title')
    Edit
@stop
@section('action_button')
    @include('admin.include.addButton',[ 'route' => route('admin.brands.index'), 'button_text' => "Back Product Color list"])
@stop

@section('css')

@stop
@section('content')
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="mb-4">Product Color Setup</h4>
                    {!! Form::model($_productColor,['route'=>['admin.product.productColorUpdate',['product_id'=>$product_id ,'productColor_id' =>$_productColor->id ]],'method'=>'POST','id'=>'brand_submit','class'=>'forms-sample','files' => true]) !!}
                    <div class="row">
                        <div class="col-lg-12 mb-3">
                            <label class="form-label" for="color_id_1">Color</label>
                            <div>
                                {!! Form::select('color_id_1',$_colorSelectList, $value = old('color_id_1'), ['id'=>'color_id_1','class'=>'form-select','placeholder'=>'Select Color']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 mb-3">
                            <label class="form-label" for="color_gradient">Color Gradient Status</label>
                            <div class="radio-put d-flex align-items-center align-middle pt-3">
                                <div class="form-check form-check-inline">
                                    {!! Form::radio('color_gradient', 1, false,['class'=>'form-check-input color_gradient' ,'id'=>'color_gradient_yes']) !!}
                                    <label class="form-check-label" for="color_gradient_yes">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    {!! Form::radio('color_gradient', 0, true,['class'=>'form-check-input color_gradient' ,'id'=>'color_gradient_no']) !!}
                                    <label class="form-check-label" for="color_gradient_no">No</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 mb-3 color_gradient_div">
                            <label class="form-label" for="color_id_2">Color 2 </label>
                            <div>
                                {!! Form::select('color_id_2',$_colorSelectList, $value = old('color_id_2'), ['id'=>'color_id_2','class'=>'form-select','placeholder'=>'Select Color']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 mb-3">
                            <label for="product_image_color" class="form-label">Product Color Image</label>
                            {!! Form::file('product_image_color',['id'=>'product_image_color','class'=>'form-control']) !!}

                            <a href="{{ $_productColor->product_image_color_path  }}" target="_blank">
                                <img src="{{ $_productColor->product_image_color_path  }}" alt="Product Color"
                                     height="100px" width="100px">
                            </a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 mb-3">
                            <label for="product_image_color" class="form-label">Product Quantity</label>
                            {!! Form::number('quantity', $value = old('quantity'), ['id'=>'quantity','placeholder'=>'Enter Quantity','class'=>'form-control' ,"autocomplete"=>'off']) !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 mb-3">
                            <label for="barcode" class="form-label">Product Barcode</label>
                            {!! Form::text('barcode', $value = old('barcode'), ['id'=>'barcode','placeholder'=>'Enter Quantity','class'=>'form-control' ,"autocomplete"=>'off']) !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">
                                <em class="link-icon" data-feather="plus"></em>
                                save
                            </button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@stop
