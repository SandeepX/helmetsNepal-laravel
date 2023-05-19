@extends('admin.master')

@section('title') Designation @stop
@section('page_title')  Create @stop
@section('action_button')
    @include('admin.include.addButton',[ 'route' => route('admin.designation.index'), 'button_text' => "Back Designation list"])
@stop
@section('content')
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="mb-4">Designation Setup</h4>
                    {!! Form::open(['route'=>'admin.designation.store','method'=>'POST','id'=>'designation_submit' ,'class'=>'forms-sample']) !!}
                        @include('admin.designation.action',['btn'=>"Save Designation"])
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@stop
