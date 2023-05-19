@extends('admin.master')

@section('title')
    Showroom
@stop
@section('page_title')
    List
@stop

@section('action_button')
    @include('admin.include.addButton',[ 'route' => route('admin.showroom.create'), 'button_text' => "Create Showroom"])
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
                            <caption>Showroom List</caption>
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Show in Contact Us </th>
                                <th>IS Featured</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($_showrooms->total() > 0)
                                @foreach($_showrooms as $showroom)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <img src="{{ $showroom->image_path  }}" alt="{{ $showroom->name }}">
                                        </td>
                                        <td>{{ $showroom->name }}</td>
                                        <td>
                                            <span class="form-check form-switch">
                                                <input type="checkbox"
                                                       href="{{route('admin.showroom.changeShowInContactUs',$showroom->id)}}"
                                                       class="form-check-input change-status-toggle"
                                                       @if($showroom->show_in_contactUs) checked @endif>
                                            </span>
                                        </td>
                                        <td>
                                            <span class="form-check form-switch">
                                                <input type="checkbox"
                                                       href="{{route('admin.showroom.changeIsFeature',$showroom->id)}}"
                                                       class="form-check-input change-status-toggle"
                                                       @if($showroom->is_feature) checked @endif>
                                            </span>
                                        </td>
                                        <td>
                                            <span class="form-check form-switch">
                                                <input type="checkbox"
                                                       href="{{route('admin.showroom.changeStatus',$showroom->id)}}"
                                                       class="form-check-input change-status-toggle"
                                                       @if($showroom->status === \App\Http\Enums\EStatus::active->value) checked @endif>
                                            </span>
                                        </td>
                                        <td>
                                            <ul class="d-flex list-unstyled mb-0">
                                                <li class="me-2">
                                                    <a href="{{route('admin.showroom.edit',['showroom'=>$showroom->id])}}">
                                                        <em class="link-icon" data-feather="edit"></em>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="delete-modal" data-bs-toggle="modal"
                                                       data-bs-target="#deleteModel"
                                                       link='{{route('admin.showroom.destroy',['showroom'=>$showroom->id])}}'>
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
    {{ $_showrooms->links('admin.include.pagination') }}
    @include('admin.include.delete-model')
@stop
