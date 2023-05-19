@extends('admin.master')

@section('title') Department @stop
@section('page_title')  List @stop

@section('action_button')
    @include('admin.include.addButton',[ 'route' => route('admin.department.create'), 'button_text' => "Create Department"])
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
                            <caption>Department List</caption>
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($_departments->total() > 0)
                                @foreach($_departments as $department)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <img src="{{ $department->image_path  }}" alt="{{ $department->title }}">
                                        </td>
                                        <td>{{ $department->title }}</td>
                                        <td>
                                            <span class="form-check form-switch">
                                                <input type="checkbox" href="{{route('admin.department.changeStatus',$department->id)}}" class="form-check-input change-status-toggle" @if($department->status === \App\Http\Enums\EStatus::active->value) checked @endif>
                                            </span>
                                        </td>
                                        <td>
                                            <ul class="d-flex list-unstyled mb-0">
                                                <li class="me-2">
                                                    <a href="{{route('admin.department.edit',['department'=>$department->id])}}">
                                                        <em class="link-icon" data-feather="edit"></em>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="delete-modal" data-bs-toggle="modal"
                                                       data-bs-target="#deleteModel"
                                                       link='{{route('admin.department.destroy',['department'=>$department->id])}}'>
                                                        <em class="link-icon" data-feather="delete"></em>
                                                    </a>
                                                </li>
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
    {{ $_departments->links('admin.include.pagination') }}
    @include('admin.include.delete-model')
@stop
