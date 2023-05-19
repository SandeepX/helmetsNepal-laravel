@extends('admin.master')

@section('title') Services @stop
@section('page_title')  Edit @stop
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
                    {!! Form::model($_slidingContent,['route'=>['admin.slidingContent.updateImageType',$_slidingContent->id],'method'=>'PUT','id'=>'slidingContent_submit','class'=>'forms-sample','files' => true]) !!}
                        @include('admin.slidingContent.action',['btn'=>"Update Services"])
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@stop
