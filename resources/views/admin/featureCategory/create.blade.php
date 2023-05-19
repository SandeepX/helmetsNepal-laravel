@extends('admin.master')

@section('title') Feature Category @stop
@section('page_title')  Create @stop
@section('action_button')
    @include('admin.include.addButton',[ 'route' => route('admin.feature-category.index'), 'button_text' => "Back Feature Category list"])
@stop
@section('content')
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="mb-4">Feature Category Setup</h4>
                    {!! Form::open(['route'=>'admin.feature-category.store','method'=>'POST','id'=>'featureCategory_submit' ,'class'=>'forms-sample']) !!}
                        @include('admin.featureCategory.action',['btn'=>"Save Feature Category"])
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@stop
