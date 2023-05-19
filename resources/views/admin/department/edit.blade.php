@extends('admin.master')

@section('title')
    Department
@stop
@section('page_title')
    Edit
@stop
@section('action_button')
    @include('admin.include.addButton',[ 'route' => route('admin.department.index'), 'button_text' => "Back Department list"])
@stop
@section('js')
    <script src="{{ asset('admin/assets/js/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/jquery-validation/additional-methods.min.js') }}"></script>
    <script src="{{ asset('admin/assets/validation/department.js') }}"></script>
@stop
@section('content')
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="mb-4">Department Setup</h4>
                    {!! Form::model($_department,['route'=>['admin.department.update',$_department->id],'method'=>'PUT','id'=>'department_submit','class'=>'forms-sample','files' => true]) !!}
                    @include('admin.department.action',['btn'=>"Update Department"])
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@stop
