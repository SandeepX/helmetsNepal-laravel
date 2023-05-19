@extends('admin.master')

@section('title')
    Career
@stop
@section('page_title')
    Create
@stop
@section('action_button')
    @include('admin.include.addButton',[ 'route' => route('admin.career.index'), 'button_text' => "Back Career  list"])
@stop
@section('css')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
@stop
@section('js')
    <!-- include summernote css/js -->
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#summernote').summernote();
        });
    </script>
    <script src="{{ asset('admin/assets/js/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/jquery-validation/additional-methods.min.js') }}"></script>
    <script src="{{ asset('admin/assets/validation/career.js') }}"></script>
@stop
@section('content')
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="mb-4">Career Setup</h4>
                    {!! Form::open(['route'=>'admin.career.store','method'=>'POST','id'=>'career_submit' ,'class'=>'forms-sample']) !!}
                    @include('admin.career.action',['btn'=>"Save Career "])
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@stop
