@extends('admin.master')

@section('title') Rider Story @stop
@section('page_title')  List @stop

@section('action_button')
    @include('admin.include.addButton',[ 'route' => route('admin.riderStory.create'), 'button_text' => "Create Rider Story"])
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
                            <caption>Rider Story List</caption>
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
                            @if($_ridersStory->total() > 0)
                                @foreach($_ridersStory as $riderStory)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <img src="{{ $riderStory->image_path  }}" alt="{{ $riderStory->title }}">
                                        </td>
                                        <td>{{ $riderStory->name }}</td>
                                        <td>
                                            <span class="form-check form-switch">
                                                <input type="checkbox"
                                                       href="{{route('admin.riderStory.changeStatus',$riderStory->id)}}"
                                                       class="form-check-input change-status-toggle"
                                                       @if($riderStory->status === \App\Http\Enums\EStatus::active->value) checked @endif>
                                            </span>
                                        </td>
                                        <td>
                                            <ul class="d-flex list-unstyled mb-0">
                                                <li class="me-2">
                                                    <a href="{{route('admin.riderStory.edit',['riderStory'=>$riderStory->id])}}">
                                                        <em class="link-icon" data-feather="edit"></em>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="delete-modal" data-bs-toggle="modal"
                                                       data-bs-target="#deleteModel"
                                                       link='{{route('admin.riderStory.destroy',['riderStory'=>$riderStory->id])}}'>
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
    {{ $_ridersStory->links('admin.include.pagination') }}
    @include('admin.include.delete-model')
@stop
