@extends('admin.master')

@section('title') Services @stop
@section('page_title')  Create @stop
@section('action_button')
    @include('admin.include.addButton',[ 'route' => route('admin.slidingContent.indexImageType'), 'button_text' => "Back Services list"])
@stop
@section('js')
    <script src="{{ asset('admin/assets/js/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/jquery-validation/additional-methods.min.js') }}"></script>
    <script src="{{ asset('admin/assets/validation/slidingContentImageType.js') }}"></script>
@stop
@section('content')
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="mb-4">Services Setup</h4>
                    {!! Form::open(['route'=>'admin.slidingContent.storeImageType','method'=>'POST','id'=>'slidingContent_submit' ,'class'=>'forms-sample','files' => true]) !!}
                        @include('admin.slidingContent.action',['btn'=>"Save Services"])
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@stop
