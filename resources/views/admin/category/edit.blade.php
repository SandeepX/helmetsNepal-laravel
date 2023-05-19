@extends('admin.master')

@section('title') Category @stop
@section('page_title')  Edit @stop
@section('action_button')
    @include('admin.include.addButton',[ 'route' => route('admin.category.index'), 'button_text' => "Back Category list"])
@stop
@section('css')
    <link rel="stylesheet" href="{{ asset('admin/assets/vendors/dropzone/dropzone.min.css') }}">
@stop
@section('js')
    <script src="{{ asset('admin/assets/vendors/dropzone/dropzone.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/dropzone.js') }}"></script>
    <script src="{{ asset('admin/assets/category.js') }}"></script>

    <script src="{{ asset('admin/assets/js/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/jquery-validation/additional-methods.min.js') }}"></script>
    <script src="{{ asset('admin/assets/validation/category.js') }}"></script>
@stop
@section('content')
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="mb-4">Category Setup</h4>
                    {!! Form::model($_category['category'],['route'=>['admin.category.update',$_category['category']->id],'method'=>'PUT','id'=>'category_submit','class'=>'forms-sample','files' => true]) !!}
                        @include('admin.category.action',['btn'=>"Update Category"])
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@stop
