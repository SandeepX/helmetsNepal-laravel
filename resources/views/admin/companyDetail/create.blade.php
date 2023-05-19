@extends('admin.master')

@section('title') Company Detail @stop
@section('page_title')  Create @stop
@section('js')
    <script src="{{ asset('admin/assets/js/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/jquery-validation/additional-methods.min.js') }}"></script>
    <script src="{{ asset('admin/assets/validation/companyDetail.js') }}"></script>
@stop
@section('content')
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="mb-4">Company Detail Setup</h4>
                    @if($_companyDetail)
                        {!! Form::model($_companyDetail,['route'=>'admin.companyDetail.companyDetailSave','method'=>'POST','id'=>'companyDetail_submit','class'=>'forms-sample','files' => true]) !!}
                    @else
                        {!! Form::open(['route'=>'admin.companyDetail.companyDetailSave','method'=>'POST','id'=>'companyDetail_submit' ,'class'=>'forms-sample','files' => true]) !!}
                    @endif
                        @include('admin.companyDetail.action',['btn'=>"Save Company Detail"])
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@stop
