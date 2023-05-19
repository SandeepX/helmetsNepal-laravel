@php use App\Http\Enums\EStatus; @endphp
@extends('admin.master')

@section('title')
    Product
@stop
@section('page_title')
    List
@stop

@section('action_button')
    @include('admin.include.addButton',[ 'route' => route('admin.product.productDiscountCreate',['product_id'=> $product_id]), 'button_text' => "Create Product Discount"])
    @include('admin.include.addButton',[ 'route' => route('admin.product.index'), 'button_text' => "Back To Product List"])
@stop
@section('js')
    {{--    <script src="{{ asset('admin/assets/product.js') }}"></script>--}}
    <script>
        $(document).ready(function () {
            $('.change-status-toggle').on('click', function (event) {

                event.preventDefault();

                Swal.fire({
                    title: 'Are you sure you want to change status ? Only One discount can be Active at a time',
                    showDenyButton: true,
                    confirmButtonText: `Yes`,
                    denyButtonText: `No`,
                    padding: '10px 50px 10px 50px',
                    allowOutsideClick: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                        let url = $(this).attr('href');
                        $.ajax({
                            type: 'POST',
                            url: url,
                            data: {
                                _token: CSRF_TOKEN,
                            },
                            success: function (results) {
                                if (results.success === true) {
                                    Swal.fire("Done!", results.message, "success");
                                    location.reload();
                                } else {
                                    Swal.fire("Error!", results.message, "error");
                                }
                            }
                        });
                    }
                });
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
                            <caption>Product List</caption>
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Start date</th>
                                <th>End date</th>
                                <th>Discount Percentage</th>
                                <th>Discount Amount</th>
                                <th>Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($_productDiscounts as $productDiscount)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{date('Y-m-d h:i A' , strtotime($productDiscount->discount_start_date)) ?? "-" }}</td>
                                    <td>{{date('Y-m-d h:i A' , strtotime($productDiscount->discount_end_date)) ?? "-" }}</td>
                                    <td>{{$productDiscount->discount_percent}} %</td>
                                    <td>{{$productDiscount->discount_amount}}</td>
                                    <td>
                                        <span class="form-check form-switch">
                                            <input type="checkbox"
                                                       href="{{route('admin.product.productDiscountChangeStatus',$productDiscount->id)}}"
                                                       class="form-check-input change-status-toggle"
                                                       @if($productDiscount->status == EStatus::active->value) checked @endif>
                                            </span>
                                    </td>
                                    <td>
                                        <ul class="d-flex list-unstyled mb-0">
                                            <li class="me-2">
                                                <a href="{{route('admin.product.productDiscountEdit',['productDiscount_id'=>$productDiscount->id])}}">
                                                    <em class="link-icon" data-feather="edit"></em>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="delete-modal" data-bs-toggle="modal"
                                                   data-bs-target="#deleteModel"
                                                   link='{{route('admin.product.productDiscountDelete',['productDiscount_id'=>$productDiscount->id])}}'>
                                                    <em class="link-icon" data-feather="delete"></em>
                                                </a>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('admin.include.delete-model')
@stop
