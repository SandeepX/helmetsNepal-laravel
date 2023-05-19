@extends('admin.master')

@section('title') Faq Category @stop
@section('page_title')  Edit @stop
@section('action_button')
    @include('admin.include.addButton',[ 'route' => route('admin.faq-category.index'), 'button_text' => "Back Faq Category list"])
@stop

@section('content')
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="mb-4">Faq Category Setup</h4>
                    {!! Form::model($_faqCategory,['route'=>['admin.faq-category.update',$_faqCategory->id],'method'=>'PUT','id'=>'faqCategory_submit','class'=>'forms-sample']) !!}
                        @include('admin.faq-category.action',['btn'=>"Update Faq Category"])
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@stop
