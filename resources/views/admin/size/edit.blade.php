@extends('admin.master')

@section('title') Size @stop
@section('page_title')  Edit @stop
@section('action_button')
    @include('admin.include.addButton',[ 'route' => route('admin.size.index'), 'button_text' => "Back Size list"])
@stop
@section('js')
    <script src="{{ asset('admin/assets/js/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/jquery-validation/additional-methods.min.js') }}"></script>
    <script src="{{ asset('admin/assets/validation/size.js') }}"></script>
@stop
@section('content')
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="mb-4">Size Setup</h4>
                    {!! Form::model($_size,['route'=>['admin.size.update',$_size->id],'method'=>'PUT','id'=>'size_submit','class'=>'forms-sample']) !!}
                        @include('admin.size.action',['btn'=>"Update Size"])
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@stop
