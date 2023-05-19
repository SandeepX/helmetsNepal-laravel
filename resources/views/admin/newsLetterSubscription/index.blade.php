@extends('admin.master')

@section('title')
    NewsLetter Subscription
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
                            <caption>NewsLetter Subscription List</caption>
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($_newsLetterSubscriptions->total() > 0)
                                @foreach($_newsLetterSubscriptions as $newsLetterSubscription)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $newsLetterSubscription->email }}</td>
                                        <td>
                                            <span class="form-check form-switch">
                                                <input type="checkbox"
                                                       href="{{route('admin.newsLetterSubscription.changeStatus',$newsLetterSubscription->id)}}"
                                                       class="form-check-input change-status-toggle"
                                                       @if($newsLetterSubscription->status === \App\Http\Enums\EStatus::active->value) checked @endif>
                                            </span>
                                        </td>
                                        <td>
                                            <ul class="d-flex list-unstyled mb-0">
                                                <li>
                                                    <a class="delete-modal" data-bs-toggle="modal"
                                                       data-bs-target="#deleteModel"
                                                       link='{{route('admin.newsLetterSubscription.destroy',['news_letter_subscription'=>$newsLetterSubscription->id])}}'>
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
    {{ $_newsLetterSubscriptions->links('admin.include.pagination') }}
    @include('admin.include.delete-model')
@stop
