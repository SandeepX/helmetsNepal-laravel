@extends('admin.master')

@section('title') Pages @stop
@section('page_title')  Create @stop
@section('action_button')
    @include('admin.include.addButton',[ 'route' => route('admin.pages.index'), 'button_text' => "Back Pages list"])
@stop
@section('css')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
@stop
@section('js')
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
                    <h4 class="mb-4">Pages Setup</h4>
                    {!! Form::open(['route'=>'admin.pages.store','method'=>'POST','id'=>'pages_submit' ,'class'=>'forms-sample']) !!}
                        @include('admin.pages.action',['btn'=>"Save Pages"])
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@stop
