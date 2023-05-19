@extends('admin.master')

@section('title')
    Team
@stop
@section('page_title')
    List
@stop

@section('action_button')
    @include('admin.include.addButton',[ 'route' => route('admin.team.create'), 'button_text' => "Create Team"])
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
                            <caption>Team List</caption>
                            <thead>
                            <tr>
                                <th>#</th>
                                <th style="width: 350px;">Image</th>
                                <th>Team Member</th>
                                <th>Designation</th>
                                <th>Feature Status</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($_teams->total() > 0)
                                @foreach($_teams as $team)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <img src="{{ $team->image_path  }}" alt="{{ $team->name }}" style="width: 200px;">
                                        </td>
                                        <td>{{ $team->name }}</td>
                                        <td>{{ $team->designation_name }}</td>
                                        <td>
                                            <span class="form-check form-switch">
                                                <input type="checkbox"
                                                       href="{{route('admin.team.changeFeaturedStatus',$team->id)}}"
                                                       class="form-check-input change-status-toggle"
                                                       @if($team->is_featured) checked @endif>
                                            </span>
                                        </td>
                                        <td>
                                            <span class="form-check form-switch">
                                                <input type="checkbox"
                                                       href="{{route('admin.team.changeStatus',$team->id)}}"
                                                       class="form-check-input change-status-toggle"
                                                       @if($team->status === \App\Http\Enums\EStatus::active->value) checked @endif>
                                            </span>
                                        </td>
                                        <td>
                                            <ul class="d-flex list-unstyled mb-0">
                                                <li class="me-2">
                                                    <a href="{{route('admin.team.edit',['team'=>$team->id])}}">
                                                        <em class="link-icon" data-feather="edit"></em>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="delete-modal" data-bs-toggle="modal"
                                                       data-bs-target="#deleteModel"
                                                       link='{{route('admin.team.destroy',['team'=>$team->id])}}'>
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
    {{ $_teams->links('admin.include.pagination') }}
    @include('admin.include.delete-model')
@stop
