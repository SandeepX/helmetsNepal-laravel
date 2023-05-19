@extends('admin.master')

@section('title') Page Banner @stop
@section('page_title')  Edit @stop
@section('action_button')
    @include('admin.include.addButton',[ 'route' => route('admin.pageBanner.index'), 'button_text' => "Back Page Banner list"])
@stop

@section('css')

@stop
@section('content')
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="mb-4">Page Banner Setup</h4>
                    {!! Form::model($_pageBanner,['route'=>['admin.pageBanner.update',$_pageBanner->id],'method'=>'PUT','id'=>'pageBanner_submit','class'=>'forms-sample','files' => true]) !!}
                        @include('admin.pageBanner.action',['btn'=>"Update Page Banner"])
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@stop
