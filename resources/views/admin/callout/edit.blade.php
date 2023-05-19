@extends('admin.master')

@section('title') Callout @stop
@section('page_title')  Edit @stop
@section('action_button')
    @include('admin.include.addButton',[ 'route' => route('admin.callout.index'), 'button_text' => "Back Callout list"])
@stop
@section('content')
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="mb-4">Callout Setup</h4>
                    {!! Form::model($_callout,['route'=>['admin.callout.update',$_callout->id],'method'=>'PUT','id'=>'callout_submit','class'=>'forms-sample','files' => true]) !!}
                        @include('admin.callout.action',['btn'=>"Update Callout"])
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@stop
