@extends('admin.master')

@section('title')
    Feature Category
@stop
@section('page_title')
    List
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
                            <caption>Feature Category List</caption>
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($_featureCategory->total() > 0)
                                @foreach($_featureCategory as $featureCategory)

                                    @if($featureCategory->name  != 'Recommended Items')
                                        <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $featureCategory->name }}</td>
                                        <td>
                                            <span class="form-check form-switch">
                                                <input type="checkbox"
                                                       href="{{route('admin.feature-category.changeStatus',$featureCategory->id)}}"
                                                       class="form-check-input change-status-toggle"
                                                       @if($featureCategory->status === \App\Http\Enums\EStatus::active->value) checked @endif>
                                            </span>
                                        </td>
                                        <td>
                                            <ul class="d-flex list-unstyled mb-0">
                                                <li class="me-2">
                                                    <a href="{{route('admin.feature-category.edit',['id'=>$featureCategory->id])}}">
                                                        <em class="link-icon" data-feather="edit"></em> Detail (Section detail)
                                                    </a>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    @endif

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
    {{ $_featureCategory->links('admin.include.pagination') }}
    @include('admin.include.delete-model')
@stop
