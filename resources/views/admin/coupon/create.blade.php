@extends('admin.master')

@section('title')
    Coupon
@stop
@section('page_title')
    Create
@stop
@section('action_button')
    @include('admin.include.addButton',[ 'route' => route('admin.coupon.index'), 'button_text' => "Back Coupon list"])
@stop


@section('css')
    <link href="{{asset('admin/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css')}}" rel="stylesheet">
@stop


@section('content')
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="mb-4">Coupon Setup</h4>
                    {!! Form::open(['route'=>'admin.coupon.store','method'=>'POST','id'=>'coupon_submit' ,'class'=>'forms-sample','files' => true]) !!}
                    @include('admin.coupon.action',['btn'=>"Save Coupon"])
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')

    <script src="{{ asset('admin/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/datepicker.js') }}"></script>
    @include('admin.coupon.scripts')
@stop


