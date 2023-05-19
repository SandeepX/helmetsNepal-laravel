@extends('admin.master')

@section('title') Callout @stop
@section('page_title')  List @stop

@section('action_button')
    @include('admin.include.addButton',[ 'route' => route('admin.callout.create'), 'button_text' => "Create Callout"])
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
                            <caption>Callout List</caption>
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Showing In</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($_callouts->total() > 0)
                                @foreach($_callouts as $callout)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <img src="{{ $callout->image_path  }}" alt="{{ $callout->title }}">
                                        </td>
                                        <td>{{ $callout->title }}</td>
                                        <td>@if($callout->type === 'about_us')
                                                About Us
                                            @elseif($callout->type === 'shop')
                                                Shop
                                            @endif</td>
                                        <td>
                                            <span class="form-check form-switch">
                                                <input type="checkbox" href="{{route('admin.callout.changeStatus',$callout->id)}}" class="form-check-input change-status-toggle" @if($callout->status === \App\Http\Enums\EStatus::active->value) checked @endif>
                                            </span>
                                        </td>
                                        <td>
                                            <ul class="d-flex list-unstyled mb-0">
                                                <li class="me-2">
                                                    <a href="{{route('admin.callout.edit',['callout'=>$callout->id])}}">
                                                        <em class="link-icon" data-feather="edit"></em>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="delete-modal" data-bs-toggle="modal"
                                                       data-bs-target="#deleteModel"
                                                       link='{{route('admin.callout.destroy',['callout'=>$callout->id])}}'>
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
    {{ $_callouts->links('admin.include.pagination') }}
    @include('admin.include.delete-model')
@stop
