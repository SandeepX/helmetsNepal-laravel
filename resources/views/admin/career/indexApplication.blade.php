@extends('admin.master')

@section('title')
    Application
@stop
@section('page_title')
    List
@stop
@section('content')
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="dataTableExample" class="table">
                            <caption>Application List</caption>
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Application Name</th>
                                <th>CV</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($_application->total() > 0)
                                @foreach($_application as $application)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $application->name }}</td>
                                        <td>{{ $application->email }}</td>
                                        <td>{{ $application->getCareer->title }}</td>
                                        <td>
                                            <a href="{{asset('/front/uploads/applications/'.$application->cv_file)}}"
                                               target="_blank"> Click Here For CV</a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td class="text-left" colspan="4">No data found.</td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{ $_application->links('admin.include.pagination') }}
@stop
