@extends('admin.master')

@section('title')
    Delivery Charge
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
                            <caption>Delivery Charge List</caption>
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Delivery Charge Title</th>
                                <th>Delivery Charge Amount</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($_deliveryCharges->total() > 0)
                                @foreach($_deliveryCharges as $deliveryCharge)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $deliveryCharge->title }}</td>
                                        <td>{{ $deliveryCharge->delivery_charge_amount }}</td>

                                        <td>
                                            <span class="form-check form-switch">
                                                <input type="checkbox"
                                                       href="{{route('admin.deliveryCharge.changeStatus',$deliveryCharge->id)}}"
                                                       class="form-check-input change-status-toggle"
                                                       @if($deliveryCharge->status === \App\Http\Enums\EStatus::active->value) checked @endif>
                                            </span>
                                        </td>
                                        <td>
                                            <ul class="d-flex list-unstyled mb-0">
                                                <li class="me-2">
                                                    <a href="{{route('admin.deliveryCharge.edit',['deliveryCharge'=>$deliveryCharge->id])}}">
                                                        <em class="link-icon" data-feather="edit"></em>
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
@stop
