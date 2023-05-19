@extends('admin.master')

@section('title')
    Coupon
@stop
@section('page_title')
    List
@stop

@section('action_button')
    @include('admin.include.addButton',[ 'route' => route('admin.coupon.create'), 'button_text' => "Create Coupon"])
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
                            <caption>Coupon List</caption>
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Campaign Name</th>
                                <th>Campaign Code</th>
                                <th>Coupon For</th>
                                <th>Coupon Starting Date</th>
                                <th>Coupon End Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($_coupons->total() > 0)
                                @foreach($_coupons as $coupon)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $coupon->campaign_name }}</td>
                                        <td>{{ $coupon->campaign_code }}</td>
                                        <td>{{ ucfirst($coupon->coupon_for) }}</td>
                                        <td>{{ $coupon->starting_date }}</td>
                                        <td>{{ $coupon->expiry_date }}</td>
                                        <td>
                                            <span class="form-check form-switch">
                                                <input type="checkbox"
                                                       href="{{route('admin.coupon.changeStatus',$coupon->id)}}"
                                                       class="form-check-input change-status-toggle"
                                                       @if($coupon->status === \App\Http\Enums\EStatus::active->value) checked @endif>
                                            </span>
                                        </td>
                                        <td>
                                            <ul class="d-flex list-unstyled mb-0">
                                                <li class="me-2">
                                                    <a href="{{route('admin.coupon.edit',['coupon'=>$coupon->id])}}">
                                                        <em class="link-icon" data-feather="edit"></em>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="delete-modal" data-bs-toggle="modal"
                                                       data-bs-target="#deleteModel"
                                                       link='{{route('admin.coupon.destroy',['coupon'=>$coupon->id])}}'>
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
    {{ $_coupons->links('admin.include.pagination') }}
    @include('admin.include.delete-model')
@stop
