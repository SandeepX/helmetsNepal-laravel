@extends('admin.master')

@section('title') Designation @stop
@section('page_title')  Edit @stop
@section('action_button')
    @include('admin.include.addButton',[ 'route' => route('admin.designation.index'), 'button_text' => "Back Designation list"])
@stop

@section('content')
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="mb-4">Designation Setup</h4>
                    {!! Form::model($_designation,['route'=>['admin.designation.update',$_designation->id],'method'=>'PUT','id'=>'designation_submit','class'=>'forms-sample']) !!}
                        @include('admin.designation.action',['btn'=>"Update Designation"])
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@stop
