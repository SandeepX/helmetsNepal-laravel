@extends('admin.master')

@section('title')
    Product Graphic
@stop
@section('page_title')
    Edit
@stop
@section('action_button')
    @include('admin.include.addButton',[ 'route' => route('admin.productGraphic.index'), 'button_text' => "Back Product Graphic list"])
@stop
@section('js')
    <script src="{{ asset('admin/assets/js/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/jquery-validation/additional-methods.min.js') }}"></script>
    <script src="{{ asset('admin/assets/validation/productGraphic.js') }}"></script>
@stop
@section('content')
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="mb-4">Product Graphic Setup</h4>
                    {!! Form::model($_productGraphic,['route'=>['admin.productGraphic.update',$_productGraphic->id],'method'=>'PUT','id'=>'productGraphic_submit','class'=>'forms-sample']) !!}
                    @include('admin.productGraphic.action',['btn'=>"Update Product Graphic"])
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@stop
