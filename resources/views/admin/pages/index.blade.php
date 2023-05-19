@extends('admin.master')

@section('title')
    Pages
@stop
@section('page_title')
    List
@stop

@section('action_button')
    @include('admin.include.addButton',[ 'route' => route('admin.pages.create'), 'button_text' => "Create Pages"])
@stop
@section('js')
    <script src="{{ asset('admin/assets/changeStatus.js') }}"></script>

    <script>
        $(document).ready(function () {
            $('.copy-modal').on('click', function () {
                var link = $(this).attr('link');
                console.log(link);
                $('.copy_link').html(link);
            });
        });
    </script>
@stop
@section('content')
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="dataTableExample" class="table">
                            <caption>Pages List</caption>
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($_pages->total() > 0)
                                @foreach($_pages as $pages)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $pages->title }}</td>
                                        <td>
                                            <span class="form-check form-switch">
                                                <input type="checkbox"
                                                       href="{{route('admin.pages.changeStatus',$pages->id)}}"
                                                       class="form-check-input change-status-toggle"
                                                       @if($pages->status === \App\Http\Enums\EStatus::active->value) checked @endif>
                                            </span>
                                        </td>
                                        <td>
                                            <ul class="d-flex list-unstyled mb-0">
                                                <li class="me-2">
                                                    <a href="{{route('admin.pages.edit',['page'=>$pages->id])}}">
                                                        <em class="link-icon" data-feather="edit"></em>
                                                    </a>
                                                </li>

                                                <li class="me-2">
                                                    <a class="delete-modal" data-bs-toggle="modal"
                                                       data-bs-target="#deleteModel"
                                                       link='{{route('admin.pages.destroy',['page'=>$pages->id])}}'>
                                                        <em class="link-icon" data-feather="delete"></em>
                                                    </a>
                                                </li>
                                                <li class="me-2">
                                                    <a class="copy-modal" data-bs-toggle="modal"
                                                       data-bs-target="#copyModel"
                                                       link='{{$fe_link}}general-page/ {{$pages->slug}}'>
                                                        <em class="link-icon" data-feather="copy"></em>Copy Link
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
    {{ $_pages->links('admin.include.pagination') }}
    @include('admin.include.delete-model')


    <div class="modal fade" id="copyModel" tabindex="-1" aria-labelledby="copyModel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h5 class="modal-title" id="exampleModalLabel">Copy Link here</h5>
                    <p class="copy_link"> </p>
                </div>
            </div>
        </div>
    </div>
@stop
