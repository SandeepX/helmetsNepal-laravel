@extends('admin.master')

@section('title')
    Product Discount
@stop
@section('page_title')
    Create
@stop
@section('action_button')
    @include('admin.include.addButton',[ 'route' => route('admin.product.productDiscountCreate',['product_id'=> $product_id]), 'button_text' => "Back to Product Discount list"])
@stop
@section('css')
    <link href="{{asset('admin/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css')}}" rel="stylesheet">
@stop
@section('js')
    <script src="{{ asset('admin/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/datepicker.js') }}"></script>
    <script src="{{ asset('admin/assets/js/datepicker.js') }}"></script>
    {{--    <script src="{{ asset('admin/assets/product.js') }}"></script>--}}
    <script>
        $('.numeric').keyup(function () {
            if (this.value.match(/[^0-9.]/g)) {
                this.value = this.value.replace(/[^0-9.]/g, '');
            }
        });
        $('input[type=radio][name=percentage_fixed]').change(function () {
            let percentage_fixed = parseInt($(this).val());
            if (percentage_fixed === 1) {
                $("#discount_amount").prop("readonly", true);
                $("#discount_percent").prop("readonly", false);
            } else {
                $("#discount_amount").prop("readonly", false);
                $("#discount_percent").prop("readonly", true);
            }
        });


        $('#discount_amount').keyup(function () {
            let product_price = parseFloat($('#product_price').val() || 0.0);
            let discount_amount = parseFloat($('#discount_amount').val() || 0.0);
            let discount_percent = (discount_amount / product_price) * 100;
            $('#discount_percent').val(discount_percent.toFixed(2))
        });

        $('#discount_percent').keyup(function () {
            let product_price = parseFloat($('#product_price').val() || 0.0);
            let discount_percent = parseFloat($('#discount_percent').val() || 0.0);
            let discount_amount = (discount_percent / 100) * product_price;
            $('#discount_amount').val(discount_amount)
        });
    </script>
@stop
@section('content')
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="mb-4">Product Discount Setup</h4>
                    {!! Form::open(['route'=>['admin.product.productDiscountSave',['product_id'=> $product_id]],'method'=>'POST','id'=>'product_submit' ,'class'=>'forms-sample','files' => true]) !!}
                    <div class="row">
                        <div class="col-lg-6 mb-3">
                            <label for="discount_start_date" class="form-label">Discount Starting Date</label>
                            <div class="input-group date datepicker" id="starting_date_input">
                                {!! Form::text('discount_start_date', $value = old('discount_start_date') , ['id'=>'starting_date','class'=>'form-control']) !!}
                                <span class="input-group-text input-group-addon"><i data-feather="calendar"></i></span>
                            </div>
                            <span class="text-danger">{{ $errors->first('discount_start_date') }}</span>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label for="discount_end_date" class="form-label">Discount End Date</label>
                            <div class="input-group date datepicker" id="expiry_date_input">
                                {!! Form::text('discount_end_date', $value = old('discount_end_date') , ['id'=>'expiry_date','class'=>'form-control']) !!}
                                <span class="input-group-text input-group-addon"><i data-feather="calendar"></i></span>
                            </div>
                            <span class="text-danger">{{ $errors->first('discount_end_date') }}</span>
                        </div>

                        <div class="col-lg-6 mb-3">
                            <label for="discount_amount" class="form-label"> Percentage/Fixed</label>
                            <div class="radio-put d-flex align-items-center align-middle pt-3">
                                <div class="form-check form-check-inline">
                                    {!! Form::radio('percentage_fixed', 1, true,['class'=>'form-check-input' ,'id'=>'percentage']) !!}
                                    <label class="form-check-label" for="custom_status_yes">Percentage</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    {!! Form::radio('percentage_fixed', 0, false,['class'=>'form-check-input' ,'id'=>'fixed']) !!}
                                    <label class="form-check-label" for="custom_status_no">Fixed</label>
                                </div>
                            </div>

                        </div>

                        <div class="col-lg-6 mb-3">
                            <label for="product_price" class="form-label"> Product Price</label>
                            {!! Form::text('product_price', $value = $_product->product_price , ['id'=>'product_price','class'=>'form-control numeric' ,'readonly']) !!}
                            <span class="text-danger">{{ $errors->first('product_price') }}</span>
                        </div>

                        <div class="col-lg-6 mb-3">
                            <label for="discount_amount" class="form-label"> Product Discount Amount</label>
                            {!! Form::text('discount_amount', $value = old('discount_amount') , ['id'=>'discount_amount','placeholder'=>'Enter Product Discount Amount','class'=>'form-control numeric' ,'readonly']) !!}
                            <span class="text-danger">{{ $errors->first('discount_amount') }}</span>
                        </div>

                        <div class="col-lg-6 mb-3">
                            <label for="discount_percent" class="form-label"> Product Discount Percentage</label>
                            {!! Form::text('discount_percent', $value = old('discount_percent') , ['id'=>'discount_percent','placeholder'=>'Enter Product Discount Percentage','class'=>'form-control numeric']) !!}
                            <span class="text-danger">{{ $errors->first('discount_percent') }}</span>
                        </div>
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
