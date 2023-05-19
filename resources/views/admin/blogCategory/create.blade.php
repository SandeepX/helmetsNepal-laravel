@extends('admin.master')

@section('title')
    Blog Category
@stop
@section('page_title')
    Create
@stop
@section('action_button')
    @include('admin.include.addButton',[ 'route' => route('admin.blogCategory.index'), 'button_text' => "Back Blog Category list"])
@stop
@section('js')
    <script src="{{ asset('admin/assets/js/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/jquery-validation/additional-methods.min.js') }}"></script>
    <script src="{{ asset('admin/assets/validation/blogCategory.js') }}"></script>
@stop
@section('content')
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="mb-4">Blog Category Setup</h4>
                    {!! Form::open(['route'=>'admin.blogCategory.store','method'=>'POST','id'=>'blogCategory_submit' ,'class'=>'forms-sample']) !!}
                    @include('admin.blogCategory.action',['btn'=>"Save Blog Category"])
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@stop
