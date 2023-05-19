@extends('admin.master')

@section('title') Product @stop
@section('page_title')  Create @stop
@section('action_button')
    @include('admin.include.addButton',[ 'route' => route('admin.product.index'), 'button_text' => "Back Product list"])
@stop
@section('css')
    <link href="{{asset('admin/assets/css/imageuploadify.min.css')}}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
@stop
@section('js')
    <script src="{{ asset('admin/assets/vendors/jquery-tags-input/jquery.tagsinput.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/tags-input.js') }}"></script>
    <script src="{{ asset('admin/assets/js/imageuploadify.min.js') }}"></script>
    <script src="{{ asset('admin/assets/product.js') }}"></script>
    <script src="{{ asset('admin/assets/js/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/jquery-validation/additional-methods.min.js') }}"></script>
    <script src="{{ asset('admin/assets/validation/product.js') }}"></script>
    <!-- include summernote css/js -->
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#summernote').summernote();
        });
    </script>
@stop
@section('content')
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="mb-4">Product Setup</h4>
                    {!! Form::open(['route'=>'admin.product.store','method'=>'POST','id'=>'product_submit' ,'class'=>'forms-sample','files' => true]) !!}
                        @include('admin.product.action',['btn'=>"Save Product"])
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@stop
