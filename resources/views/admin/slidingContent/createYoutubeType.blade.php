@extends('admin.master')

@section('title') Youtube Slider @stop
@section('page_title')  Create @stop
@section('action_button')
    @include('admin.include.addButton',[ 'route' => route('admin.slidingContent.indexYoutubeType'), 'button_text' => "Back Youtube Slider list"])
@stop
@section('js')
    <script src="{{ asset('admin/assets/js/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/jquery-validation/additional-methods.min.js') }}"></script>
    <script src="{{ asset('admin/assets/validation/slidingContentYoutubeType.js') }}"></script>
@stop
@section('content')
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="mb-4">Youtube Slider Setup</h4>
                    {!! Form::open(['route'=>'admin.slidingContent.storeYoutubeType','method'=>'POST','id'=>'slidingContent_submit' ,'class'=>'forms-sample','files' => true]) !!}
                        @include('admin.slidingContent.actionYoutube',['btn'=>"Save Youtube Slider"])
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@stop
