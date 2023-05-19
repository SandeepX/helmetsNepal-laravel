@extends('admin.master')

@section('title') Showroom @stop
@section('page_title')  Create @stop
@section('action_button')
    @include('admin.include.addButton',[ 'route' => route('admin.showroom.index'), 'button_text' => "Back Showroom list"])
@stop
@section('js')
    <script src="{{ asset('admin/assets/js/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/jquery-validation/additional-methods.min.js') }}"></script>
    <script src="{{ asset('admin/assets/validation/showroom.js') }}"></script>
@stop
@section('content')
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="mb-4">Showroom Setup</h4>
                    {!! Form::open(['route'=>'admin.showroom.store','method'=>'POST','id'=>'showroom_submit' ,'class'=>'forms-sample','files' => true]) !!}
                        @include('admin.showroom.action',['btn'=>"Save Showroom"])
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@stop
