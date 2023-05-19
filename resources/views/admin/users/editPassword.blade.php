@extends('admin.master')

@section('title')
    User
@stop
@section('page_title')
    Edit Password
@stop
@section('action_button')
    @include('admin.include.addButton',[ 'route' => route('admin.users.index'), 'button_text' => "Back User"])
@stop
@section('content')
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="mb-4">Edit Password</h4>
                    {!! Form::model($_user,['route'=>['admin.users.savePassword',$_user->id],'method'=>'POST','id'=>'user_submit','class'=>'forms-sample']) !!}
                    <div class="row">
                        <div class="col-lg-6 mb-3">
                            <label for="name" class="form-label"> Password</label>
                            {!! Form::text('password', $value = '', ['id'=>'password','placeholder'=>'Enter Password','class'=>'form-control']) !!}
                            <span class="text-danger">{{ $errors->first('name') }}</span>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary"><i class="link-icon" data-feather="plus"></i>
                                Update Password
                            </button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@stop
