@extends('admin.master')

@section('title') Banner @stop
@section('page_title')  Edit @stop
@section('action_button')
    @include('admin.include.addButton',[ 'route' => route('admin.banners.index'), 'button_text' => "Back Banner list"])
@stop

@section('js')
    <script src="{{ asset('admin/assets/js/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/jquery-validation/additional-methods.min.js') }}"></script>
    <script src="{{ asset('admin/assets/validation/banner.js') }}"></script>
@stop
@section('content')
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="mb-4">Banner Setup</h4>
                    {!! Form::model($_banner,['route'=>['admin.banners.update',$_banner->id],'method'=>'PUT','id'=>'banner_submit','class'=>'forms-sample','files' => true]) !!}
                        @include('admin.banners.action',['btn'=>"Update Banner"])
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@stop
