@extends('admin.master')

@section('title')
    Review
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
                            <caption>Review List</caption>
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Product Name</th>
                                <th>Customer Name</th>
                                <th>Review Star</th>
                                <th>Review</th>
                                <th>Publish Review</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($_review->total() > 0)
                                @foreach($_review as $review)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <a href="{{route('admin.product.show',['product'=>$review->getProduct->id])}}" target="_blank"  title="Product Details">
                                                {{ $review->getProduct->title }}
                                            </a>
                                        </td>
                                        <td>
                                            <a href="{{route('admin.customer.customerDetail',['customer_id'=>$review->getCustomer->id])}}"
                                               title="Customer Details" target="_blank">
                                                {{ $review->getCustomer->full_name }}
                                            </a>
                                        </td>
                                        <td>{{ $review->review_star }}</td>
                                        <td>{{ $review->review }}</td>
                                        <td>
                                            <span class="form-check form-switch">
                                                <input type="checkbox"
                                                       href="{{route('admin.review.changeStatus',$review->id)}}"
                                                       class="form-check-input change-status-toggle"
                                                       @if($review->publish_status) checked @endif>
                                            </span>
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
    {{ $_review->links('admin.include.pagination') }}
    @include('admin.include.delete-model')
@stop
