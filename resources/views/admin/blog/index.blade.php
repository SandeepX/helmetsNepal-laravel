@extends('admin.master')

@section('title')
    Blog
@stop
@section('page_title')
    List
@stop

@section('action_button')
    @include('admin.include.addButton',[ 'route' => route('admin.blog.create'), 'button_text' => "Create Blog "])
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
                            <caption>Blog List</caption>
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Blog Category</th>
                                <th>Feature status</th>
                                <th>status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($_blog->total() > 0)
                                @foreach($_blog as $blog)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $blog->title }}</td>
                                        <td>{{ $blog->blog_category_name }}</td>
                                        <td>
                                            <span class="form-check form-switch">
                                                <input type="checkbox"
                                                       href="{{route('admin.blog.changeFeaturedStatus',$blog->id)}}"
                                                       class="form-check-input change-status-toggle"
                                                       @if($blog->is_featured) checked @endif>
                                            </span>
                                        </td>
                                        <td>
                                            <span class="form-check form-switch">
                                                <input type="checkbox"
                                                       href="{{route('admin.blog.changeStatus',$blog->id)}}"
                                                       class="form-check-input change-status-toggle"
                                                       @if($blog->status === \App\Http\Enums\EStatus::active->value) checked @endif>
                                            </span>
                                        </td>
                                        <td>
                                            <ul class="d-flex list-unstyled mb-0">
                                                <li class="me-2">
                                                    <a href="{{route('admin.blog.edit',['blog'=>$blog->id])}}">
                                                        <em class="link-icon" data-feather="edit"></em>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="delete-modal" data-bs-toggle="modal"
                                                       data-bs-target="#deleteModel"
                                                       link='{{route('admin.blog.destroy',['blog'=>$blog->id])}}'>
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
    {{ $_blog->links('admin.include.pagination') }}
    @include('admin.include.delete-model')
@stop
