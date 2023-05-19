@extends('admin.master')

@section('title')
    Brand
@stop
@section('page_title')
    Create
@stop
@section('action_button')
    @include('admin.include.addButton',[ 'route' => route('admin.brands.index'), 'button_text' => "Back Brand list"])
@stop
@section('js')
    <script src="{{ asset('admin/assets/js/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/jquery-validation/additional-methods.min.js') }}"></script>
    <script src="{{ asset('admin/assets/validation/brand.js') }}"></script>
@stop
@section('content')
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="mb-4">Brand Setup</h4>
                    {!! Form::open(['route'=>'admin.brands.store','method'=>'POST','id'=>'brands_submit' ,'class'=>'forms-sample','files' => true]) !!}
                    @include('admin.brands.action',['btn'=>"Save Brand"])
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@stop
