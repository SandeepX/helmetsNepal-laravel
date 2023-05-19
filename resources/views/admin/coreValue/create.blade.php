@extends('admin.master')

@section('title') Core Value @stop
@section('page_title')  Create @stop
@section('action_button')
    @include('admin.include.addButton',[ 'route' => route('admin.coreValue.index'), 'button_text' => "Back Core Value list"])
@stop
@section('content')
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="mb-4">Core Value Setup</h4>
                    {!! Form::open(['route'=>'admin.coreValue.store','method'=>'POST','id'=>'coreValue_submit' ,'class'=>'forms-sample','files' => true]) !!}
                        @include('admin.coreValue.action',['btn'=>"Save Core Value"])
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@stop
