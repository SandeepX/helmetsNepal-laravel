@extends('admin.master')

@section('title') Company Setting @stop
@section('page_title')  Create @stop
@section('js')
    <script src="{{ asset('admin/assets/js/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/jquery-validation/additional-methods.min.js') }}"></script>
    <script src="{{ asset('admin/assets/validation/companySetting.js') }}"></script>
@stop
@section('content')
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="mb-4">Company Setting Setup</h4>
                    @if($_companySetting)
                        {!! Form::model($_companySetting,['route'=>'admin.companySetting.companySettingSave','method'=>'POST','id'=>'companySetting_submit','class'=>'forms-sample','files' => true]) !!}
                    @else
                        {!! Form::open(['route'=>'admin.companySetting.companySettingSave','method'=>'POST','id'=>'companySetting_submit' ,'class'=>'forms-sample','files' => true]) !!}
                    @endif
                    <div class="row">
                        <div class="col-lg-12 mb-3">
                            <label for="return_days" class="form-label"> Return Days </label>
                            {!! Form::text('return_days', $value = old('return_days'), ['id'=>'return_days','placeholder'=>'Enter Return Days','class'=>'form-control']) !!}
                            <span class="text-danger">{{ $errors->first('return_days') }}</span>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary"><i class="link-icon" data-feather="plus"></i> Save</button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@stop
