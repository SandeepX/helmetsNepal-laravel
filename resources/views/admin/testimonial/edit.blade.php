@extends('admin.master')

@section('title') Testimonial @stop
@section('page_title')  Edit @stop
@section('action_button')
    @include('admin.include.addButton',[ 'route' => route('admin.testimonial.index'), 'button_text' => "Back Testimonial list"])
@stop

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
@stop
@section('js')
    <!-- include summernote css/js -->
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#summernote').summernote();
        });
    </script>
    <script src="{{ asset('admin/assets/js/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/jquery-validation/additional-methods.min.js') }}"></script>
    <script src="{{ asset('admin/assets/validation/testimonial.js') }}"></script>
@stop
@section('content')
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="mb-4">Testimonial Setup</h4>
                    {!! Form::model($_testimonial,['route'=>['admin.testimonial.update',$_testimonial->id],'method'=>'PUT','id'=>'testimonial_submit','class'=>'forms-sample','files' => true]) !!}
                        @include('admin.testimonial.action',['btn'=>"Update Testimonial"])
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@stop
