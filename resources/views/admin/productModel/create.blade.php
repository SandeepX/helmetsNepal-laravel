@extends('admin.master')

@section('title')
    Product Model
@stop
@section('page_title')
    Create
@stop
@section('action_button')
    @include('admin.include.addButton',[ 'route' => route('admin.productModel.index'), 'button_text' => "Back Product Model list"])
@stop
@section('js')
    <script src="{{ asset('admin/assets/js/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/jquery-validation/additional-methods.min.js') }}"></script>
    <script src="{{ asset('admin/assets/validation/productModel.js') }}"></script>
@stop
@section('content')
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="mb-4">Product Model Setup</h4>
                    {!! Form::open(['route'=>'admin.productModel.store','method'=>'POST','id'=>'productModel_submit' ,'class'=>'forms-sample']) !!}
                    @include('admin.productModel.action',['btn'=>"Save Product Model"])
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@stop
