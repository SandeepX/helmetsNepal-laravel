@extends('admin.master')

@section('title') Color @stop
@section('page_title')  Edit @stop
@section('action_button')
    @include('admin.include.addButton',[ 'route' => route('admin.colors.index'), 'button_text' => "Back Color list"])
@stop

@section('content')
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="mb-4">Color Setup</h4>
                    {!! Form::model($_color,['route'=>['admin.colors.update',$_color->id],'method'=>'PUT','id'=>'colors_submit','class'=>'forms-sample']) !!}
                        @include('admin.colors.action',['btn'=>"Update Color"])
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@stop
