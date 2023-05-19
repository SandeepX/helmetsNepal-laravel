@extends('admin.master')

@section('title') Team @stop
@section('page_title')  Edit @stop
@section('action_button')
    @include('admin.include.addButton',[ 'route' => route('admin.team.index'), 'button_text' => "Back Team list"])
@stop
@section('js')
    <script src="{{ asset('admin/assets/js/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/jquery-validation/additional-methods.min.js') }}"></script>
    <script src="{{ asset('admin/assets/validation/team.js') }}"></script>
@stop
@section('content')
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="mb-4">Team Setup</h4>
                    {!! Form::model($_team,['route'=>['admin.team.update',$_team->id],'method'=>'PUT','id'=>'team_submit','class'=>'forms-sample','files' => true]) !!}
                        @include('admin.team.action',['btn'=>"Update Team"])
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@stop
