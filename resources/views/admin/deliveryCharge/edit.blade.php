@extends('admin.master')

@section('title')
    Delivery Charge
@stop
@section('page_title')
    Edit
@stop
@section('action_button')
    @include('admin.include.addButton',[ 'route' => route('admin.deliveryCharge.index'), 'button_text' => "Back Delivery Charge list"])
@stop

@section('content')
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="mb-4">Delivery Charge Setup</h4>
                    {!! Form::model($_deliveryCharge,['route'=>['admin.deliveryCharge.update',$_deliveryCharge->id],'method'=>'PUT','id'=>'deliveryCharge_submit','class'=>'forms-sample']) !!}
                    @include('admin.deliveryCharge.action',['btn'=>"Update Delivery Charge"])
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@stop
