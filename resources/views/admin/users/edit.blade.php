@extends('admin.master')

@section('title') User @stop
@section('page_title')  Edit @stop
@section('action_button')
    @include('admin.include.addButton',[ 'route' => route('admin.users.index'), 'button_text' => "Back User"])
@stop
@section('content')
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="mb-4">User Setup</h4>
                    {!! Form::model($_user,['route'=>['admin.users.update',$_user->id],'method'=>'PUT','id'=>'user_submit','class'=>'forms-sample','files' => true]) !!}
                    <div class="row">
                        <div class="col-lg-12 mb-3">
                            <label for="user_image" class="form-label">Upload User Image</label>
                            {!! Form::file('user_image',['id'=>'user_image','class'=>'form-control']) !!}
                            <span class="text-danger">{{ $errors->first('user_image') }}</span>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label for="name" class="form-label"> Full Name</label>
                            {!! Form::text('name', $value = null, ['id'=>'name','placeholder'=>'Enter Name','class'=>'form-control']) !!}
                            <span class="text-danger">{{ $errors->first('name') }}</span>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label for="email" class="form-label"> Email Address</label>
                            {!! Form::email('email', $value = null, ['id'=>'email','placeholder'=>'Enter Name','class'=>'form-control']) !!}
                            <span class="text-danger">{{ $errors->first('email') }}</span>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label for="phone" class="form-label"> Phone Number</label>
                            {!! Form::text('phone', $value = null, ['id'=>'phone','placeholder'=>'Enter Name','class'=>'form-control']) !!}
                            <span class="text-danger">{{ $errors->first('phone') }}</span>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label for="username" class="form-label"> Username</label>
                            {!! Form::text('username', $value = null, ['id'=>'username','placeholder'=>'Enter Name','class'=>'form-control']) !!}
                            <span class="text-danger">{{ $errors->first('username') }}</span>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary"><i class="link-icon" data-feather="plus"></i> update User</button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@stop
