@extends('admin.master')

@section('title')
    User
@stop
@section('page_title')
    List
@stop

@section('action_button')
    @include('admin.include.addButton',[ 'route' => route('admin.users.create'), 'button_text' => "Create User"])
@stop
@section('js')
    <script src="{{ asset('admin/assets/changeStatus.js') }}"></script>
@stop
@section('content')
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="dataTableExample" class="table">
                            <caption>User List</caption>
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($_users->total() > 0)
                                @foreach($_users as $users)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <img src="{{ $users->image_path  }}" alt="{{ $users->name }}">
                                        </td>
                                        <td>{{ $users->name }}</td>
                                        <td>
                                            <span class="form-check form-switch">
                                                <input type="checkbox"
                                                       href="{{route('admin.users.changeStatus',$users->id)}}"
                                                       class="form-check-input change-status-toggle"
                                                       @if($users->status) checked @endif>
                                            </span>
                                        </td>
                                        <td>

                                            <ul class="d-flex list-unstyled mb-0">
                                                <li class="me-2">
                                                    <a href="{{route('admin.users.edit',['user'=>$users->id])}}">
                                                        <em class="link-icon" data-feather="edit"></em>
                                                    </a>
                                                </li>
                                                <li class="me-2">
                                                    <a href="{{route('admin.users.changePassword',['id'=>$users->id])}}">
                                                        <em class="link-icon" data-feather="edit"></em>
                                                    </a>
                                                </li>
                                                @if($users->id !== 1)
                                                    <li>
                                                        <a class="delete-modal" data-bs-toggle="modal"
                                                           data-bs-target="#deleteModel"
                                                           link='{{route('admin.users.destroy',['user'=>$users->id])}}'>
                                                            <em class="link-icon" data-feather="delete"></em>
                                                        </a>
                                                    </li>
                                                @endif
                                            </ul>
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
    {{ $_users->links('admin.include.pagination') }}
    @include('admin.include.delete-model')
@stop
