@extends('admin.master')

@section('title') Youtube Slider @stop
@section('page_title')  Edit @stop
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
                    {!! Form::model($_slidingContent,['route'=>['admin.slidingContent.updateYoutubeType',$_slidingContent->id],'method'=>'PUT','id'=>'slidingContent_submit','class'=>'forms-sample','files' => true]) !!}
                        @include('admin.slidingContent.actionYoutube',['btn'=>"Update Youtube Slider"])
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@stop
