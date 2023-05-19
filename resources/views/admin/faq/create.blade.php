@extends('admin.master')

@section('title') Faq  @stop
@section('page_title')  Create @stop
@section('action_button')
    @include('admin.include.addButton',[ 'route' => route('admin.faq.index'), 'button_text' => "Back Faq  list"])
@stop
@section('content')
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="mb-4">Faq  Setup</h4>
                    {!! Form::open(['route'=>'admin.faq.store','method'=>'POST','id'=>'faq_submit' ,'class'=>'forms-sample']) !!}
                        @include('admin.faq.action',['btn'=>"Save Faq "])
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@stop
