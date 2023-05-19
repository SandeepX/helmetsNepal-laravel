@extends('admin.master')

@section('title') Ad Block @stop
@section('page_title')  Edit @stop
@section('action_button')
    @include('admin.include.addButton',[ 'route' => route('admin.adBlock.index'), 'button_text' => "Back Ad Block list"])
@stop

@section('js')
    <script src="{{ asset('admin/assets/js/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/jquery-validation/additional-methods.min.js') }}"></script>
    <script src="{{ asset('admin/assets/validation/adBlock.js') }}"></script>
@stop
@section('content')
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="mb-4">Ad Block Setup</h4>
                    {!! Form::model($_adBlock,['route'=>['admin.adBlock.update',$_adBlock->id],'method'=>'PUT','id'=>'adBlock_submit','class'=>'forms-sample','files' => true]) !!}
                        @include('admin.adBlock.action',['btn'=>"Update Ad Block"])
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@stop
