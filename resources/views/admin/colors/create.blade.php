@extends('admin.master')

@section('title') Color @stop
@section('page_title')  Create @stop
@section('action_button')
    @include('admin.include.addButton',[ 'route' => route('admin.colors.index'), 'button_text' => "Back Color list"])
@stop
@section('css')
    <link rel="stylesheet" href="{{ asset('admin/assets/vendors/dropzone/dropzone.min.css') }}">
@stop
@section('js')

    <script src="{{ asset('admin/assets/vendors/dropzone/dropzone.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/dropzone.js') }}"></script>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="mb-4">Color Setup</h4>
                    {!! Form::open(['route'=>'admin.colors.store','method'=>'POST','id'=>'colors_submit' ,'class'=>'forms-sample']) !!}
                        @include('admin.colors.action',['btn'=>"Save Color"])
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@stop
