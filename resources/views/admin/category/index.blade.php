@extends('admin.master')

@section('title')
    Category
@stop
@section('page_title')
    List
@stop

@section('action_button')
    @include('admin.include.addButton',[ 'route' => route('admin.category.create'), 'button_text' => "Create Category"])
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
                            <caption>Category List</caption>
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Parent Name</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($_category->total() > 0)
                                @foreach($_category as $category)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $category->name }}</td>
                                        <td>{{ $category->getParentCategory?->name }}</td>
                                        <td>
                                            <span class="form-check form-switch">
                                                <input type="checkbox" href="{{route('admin.category.changeStatus',$category->id)}}" class="form-check-input change-status-toggle" @if($category->status === \App\Http\Enums\EStatus::active->value) checked @endif>
                                            </span>
                                        </td>
                                        <td>
                                            <ul class="d-flex list-unstyled mb-0">
                                                <li class="me-2">
                                                    <a href="{{route('admin.category.edit',['category'=>$category->id])}}">
                                                        <em class="link-icon" data-feather="edit"></em>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="delete-modal" data-bs-toggle="modal"
                                                       data-bs-target="#deleteModel"
                                                       link='{{route('admin.category.destroy',['category'=>$category->id])}}'>
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
    {{ $_category->links('admin.include.pagination') }}
    @include('admin.include.delete-model')
@stop
