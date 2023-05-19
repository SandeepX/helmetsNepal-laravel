@extends('admin.master')

@section('title')
    Manufacture
@stop
@section('page_title')
    Create
@stop
@section('action_button')
    @include('admin.include.addButton',[ 'route' => route('admin.manufacture.index'), 'button_text' => "Back Manufacture list"])
@stop
@section('js')
    <script src="{{ asset('admin/assets/js/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/jquery-validation/additional-methods.min.js') }}"></script>
    <script src="{{ asset('admin/assets/validation/manufacture.js') }}"></script>
@stop
@section('content')
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="mb-4">Manufacture Setup</h4>
                    {!! Form::open(['route'=>'admin.manufacture.store','method'=>'POST','id'=>'manufacture_submit' ,'class'=>'forms-sample']) !!}
                    @include('admin.manufacture.action',['btn'=>"Save Manufacture"])
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@stop
