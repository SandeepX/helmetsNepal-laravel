@extends('admin.master')

@section('title') About Us @stop
@section('page_title')  Create @stop
@section('js')
    <script src="{{ asset('admin/assets/js/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/jquery-validation/additional-methods.min.js') }}"></script>
    <script src="{{ asset('admin/assets/validation/aboutUs.js') }}"></script>
@stop
@section('content')
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="mb-4">About Us Setup</h4>
                    @if($_aboutUs)
                        {!! Form::model($_aboutUs,['route'=>'admin.aboutUs.aboutUsSave','method'=>'POST','id'=>'aboutUs_submit','class'=>'forms-sample','files' => true]) !!}
                    @else
                        {!! Form::open(['route'=>'admin.aboutUs.aboutUsSave','method'=>'POST','id'=>'aboutUs_submit' ,'class'=>'forms-sample','files' => true]) !!}
                    @endif
                        @include('admin.aboutUs.action',['btn'=>"Save About Us"])
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@stop
