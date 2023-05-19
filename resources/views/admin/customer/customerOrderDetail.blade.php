@extends('admin.master')

@section('title')
    Order Management
@stop
@section('page_title')
    Customer Management
@stop
@section('action_button')
    @include('admin.include.addButton',[ 'route' => route('admin.customer.customerList'), 'button_text' => "Back Customer list"])
@stop
@section('content')
    <div class="search-box p-4 bg-white rounded mb-3 box-shadow">
        <form class="forms-sample">
            <h5 class="mb-3">Order Detail</h5>
            <div class="row">
                <div class="col-lg-3">
                    <div class="orer-detail-item border rounded p-4">
                        <h6 class="border-bottom mb-3 pb-3">Customer</h6>
                        <ul class="list-unstyled mb-0">
                            <li>Twitter, Inc.</li>
                            <li>795 Folsom Ave, Suite 600</li>
                            <li>San Francisco, CA 94107</li>
                            <li>P: (123) 456-7890</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="orer-detail-item border rounded p-4">
                        <h6 class="border-bottom mb-3 pb-3">Shipped To</h6>
                        <ul class="list-unstyled mb-0">
                            <li>Elaine Hernandez</li>
                            <li>P. Sherman 42,</li>
                            <li>Wallaby Way, Sidney</li>
                            <li>P: (123) 456-7890</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="orer-detail-item border rounded p-4">
                        <h6 class="border-bottom mb-3 pb-3">Payment Method</h6>
                        <ul class="list-unstyled mb-0">
                            <li>Visa ending **** 1234</li>
                            <li>h.elaine@gmail.com</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="orer-detail-item border rounded p-4">
                        <h6 class="border-bottom mb-3 pb-3">Order Date</h6>
                        <ul class="list-unstyled mb-0">
                            <li>4:34PM,</li>
                            <li>Wed, Aug 13, 2020</li>
                        </ul>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="dataTableExample" class="table">
                    <thead>
                    <tr><th class="text-center" colspan="4">Tracking Order No. - 34VB5540K83</th></tr>
                    </thead>
                    <tbody>
                    <tr class="text-center">
                        <td>Shipped Via: UPS Ground</td>
                        <td>Status: Checking Quality</td>
                        <td>Expected Date: Jun 09, 2022</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="order-track mt-3 position-relative">
                <div class="row">
                    <div class="col-lg">
                        <div class="order-track-item text-center">
                            <div class="track-icon"><i class="link-icon" data-feather="shopping-cart"></i></div>
                            <p>Confirmed Order</p>
                        </div>
                    </div>
                    <div class="col-lg">
                        <div class="order-track-item text-center">
                            <div class="track-icon"><i class="link-icon" data-feather="tag"></i></div>
                            <p>Processing Order</p>
                        </div>
                    </div>
                    <div class="col-lg">
                        <div class="order-track-item text-center">
                            <div class="track-icon"><i class="link-icon" data-feather="gift"></i></div>
                            <p>Product Dispatched</p>
                        </div>
                    </div>
                    <div class="col-lg">
                        <div class="order-track-item text-center">
                            <div class="track-icon track-icon1"><i class="link-icon" data-feather="truck"></i></div>
                            <p>On Delivery</p>
                        </div>
                    </div>
                    <div class="col-lg">
                        <div class="order-track-item text-center">
                            <div class="track-icon track-icon1"><i class="link-icon" data-feather="user-check"></i></div>
                            <p>Product Delivered</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h5 class="text-center border-bottom mb-3 pb-3">Product Summary</h5>
                    <div class="table-responsive">
                        <table id="dataTableExample" class="table">
                            <thead>
                            <tr>
                                <th>S.N.</th>
                                <th>Product Code</th>
                                <th>Product Image</th>
                                <th>Product Name</th>
                                <th>Product Category</th>
                                <th>Product Brand</th>
                                <th class="text-center">Quantity</th>
                                <th class="text-center">Product Price</th>
                                <th class="text-center">Discount Amount</th>
                                <th class="text-center">Selling Price</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>1</td>
                                <td>Product-code</td>
                                <td>Image</td>
                                <td>Baby Pink Shoes</td>
                                <td>Baby Pink Shoes</td>
                                <td>Baby Pink Shoes</td>
                                <td class="text-center">10</td>
                                <td class="text-center">$100.00</td>
                                <td class="text-center">$100.00</td>
                                <td class="text-center"><span class="fw-bold">$100.00</span></td>
                            </tr>


                            <tr>
                                <td colspan="8"></td>
                                <td class="text-center">
                                    <strong>Subtotal</strong>
                                </td>
                                <td class="text-center">$300.00</td>
                            </tr>
                            <tr>
                                <td colspan="8"></td>
                                <td class="text-center">
                                    <strong>Discount (20%)</strong>
                                </td>
                                <td class="text-center">$60.00</td>
                            </tr>
                            <tr>
                                <td colspan="8"></td>
                                <td class="text-center">
                                    <strong>VAT (10%)</strong>
                                </td>
                                <td class="text-center">$30.00</td>
                            </tr>
                            <tr>
                                <td colspan="8"></td>
                                <td class="text-center">
                                    <strong>Total</strong>
                                </td>
                                <td class="text-center">
                                    <strong>$270.00</strong>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


@stop
