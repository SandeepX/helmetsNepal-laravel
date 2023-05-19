@extends('admin.master')

@section('title')
    Product Color
@stop
@section('page_title')
    Create
@stop
@section('action_button')
    @include('admin.include.addButton',[ 'route' => route('admin.product.index'), 'button_text' => "Back Product Color list"])
@stop
@section('js')
    <script src="{{ asset('admin/assets/product.js') }}"></script>
@stop
@section('content')
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="mb-4">Product Color Setup</h4>
                    {!! Form::open(['route'=>['admin.product.productColorSave',['product_id'=> $product_id]],'method'=>'POST','id'=>'product_submit' ,'class'=>'forms-sample','files' => true]) !!}
                    <div class="row">
                        <div class="col-lg-12 mb-3">
                            <label class="form-label" for="color_id_1">Color</label>
                            <div>
                                {!! Form::select('color_id_1',$_colorSelectList, $value = null, ['id'=>'color_id_1','class'=>'form-select','placeholder'=>'Select Color']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 mb-3">
                            <label class="form-label" for="color_gradient">Color Gradient Status</label>
                            <div class="radio-put d-flex align-items-center align-middle pt-3">
                                <div class="form-check form-check-inline">
                                    <input type="radio" name="color_gradient" value="1"
                                           class="form-check-input color_gradient">
                                    <label class="form-check-label">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input type="radio" name="color_gradient" value="0"
                                           class="form-check-input color_gradient"
                                           checked>
                                    <label class="form-check-label">No</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 mb-3 color_gradient_div">
                            <label class="form-label" for="color_id_2">Color 2 </label>
                            <div>
                                {!! Form::select('color_id_2',$_colorSelectList, $value = null, ['id'=>'color_id_2','class'=>'form-select','placeholder'=>'Select Color']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 mb-3">
                            <label for="product_image_color" class="form-label">Product Color Image</label>
                            {!! Form::file('product_image_color',['id'=>'product_image_color','class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 mb-3">
                            <label for="quantity" class="form-label">Product Quantity</label>
                            {!! Form::text('quantity', $value = old('quantity'), ['id'=>'quantity','placeholder'=>'Enter Quantity','class'=>'form-control' ,"autocomplete"=>'off']) !!}
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
