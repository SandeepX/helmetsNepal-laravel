@extends('admin.master')

@section('title')
    Contact Us
@stop
@section('page_title')
    List
@stop
@section('action_button')
    @include('admin.include.addButton',[ 'route' => route('admin.contactUs.index'), 'button_text' => "Back list"])
@stop
@section('content')
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="dataTableExample" class="table">
                            <caption>Contact Us Detail</caption>
                            <tbody>
                            <tr>
                                <th>Name</th>
                                <td>{{$contact_us->full_name}}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{$contact_us->email}}</td>
                            </tr>
                            <tr>
                                <th>Contact no</th>
                                <td>{{$contact_us->phone}}</td>
                            </tr>
                            <tr>
                                <th>Message</th>
                                <td>{{$contact_us->message}}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
