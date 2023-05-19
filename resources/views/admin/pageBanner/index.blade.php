@extends('admin.master')

@section('title')
    Page Banner
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
                            <caption>Page Banner List</caption>
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Page Name</th>
                                <th>Page Title</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($_pageBanners as $pageBanner)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ ucfirst(str_replace('_', ' ', $pageBanner->page_name)) }}</td>
                                    <td>{{  $pageBanner->page_title }}</td>
                                    <td>
                                        <ul class="d-flex list-unstyled mb-0">
                                            <li class="me-2">
                                                <a href="{{route('admin.pageBanner.edit',['pageBanner'=>$pageBanner->id])}}">
                                                    <em class="link-icon" data-feather="edit"></em>
                                                </a>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
