@extends('admin.master')

@section('title') Banner @stop
@section('page_title')  List @stop

@section('action_button')
    @include('admin.include.addButton',[ 'route' => route('admin.banners.create'), 'button_text' => "Create Banner"])
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
                            <caption>Banner List</caption>
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Feature Status</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($_banners->total() > 0)
                                @foreach($_banners as $banner)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <img src="{{ $banner->image_path  }}" alt="{{ $banner->title }}">
                                        </td>
                                        <td>{{ $banner->title }}</td>
                                        <td>
                                            <span class="form-check form-switch">
                                                <input type="checkbox" href="{{route('admin.banners.changeFeatureStatus',$banner->id)}}" class="form-check-input change-status-toggle" @if((int)$banner->feature_status) checked @endif>
                                            </span>
                                        </td>
                                        <td>
                                            <span class="form-check form-switch">
                                                <input type="checkbox" href="{{route('admin.banners.changeStatus',$banner->id)}}" class="form-check-input change-status-toggle" @if($banner->status === \App\Http\Enums\EStatus::active->value) checked @endif>
                                            </span>
                                        </td>
                                        <td>
                                            <ul class="d-flex list-unstyled mb-0">
                                                <li class="me-2">
                                                    <a href="{{route('admin.banners.edit',['banner'=>$banner->id])}}">
                                                        <em class="link-icon" data-feather="edit"></em>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="delete-modal" data-bs-toggle="modal"
                                                       data-bs-target="#deleteModel"
                                                       link='{{route('admin.banners.destroy',['banner'=>$banner->id])}}'>
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
    {{ $_banners->links('admin.include.pagination') }}
    @include('admin.include.delete-model')
@stop
