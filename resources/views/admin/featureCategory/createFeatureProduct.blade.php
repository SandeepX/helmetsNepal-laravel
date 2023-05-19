@extends('admin.master')
@section('title')
{{$_feature_category->name}}
@stop
@section('page_title')
    List
@stop
@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet"/>
@stop
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script src="{{ asset('admin/assets/featureCategory.js') }}"></script>
@stop
@section('action_button')
    @include('admin.include.addButton',[ 'route' => route('admin.featureCategory.listFeatureCategory', ['feature_category'=> $_feature_category->slug]), 'button_text' => "Back Feature Category list"])
@stop
@section('content')
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="mb-4">{{$_feature_category->name}} Setup</h4>
                    {!! Form::open(['route'=>['admin.featureCategory.storeFeatureCategory' , ['feature_category'=> $_feature_category->slug]],'method'=>'POST','id'=>'featureCategory_submit' ,'class'=>'forms-sample']) !!}
                    <div class="row">
                        <div class="col-lg-10 mb-3">
                            <label for="live_search_product" class="form-label"> Select Category</label>
                            <select class="live_search_product form-control" name="live_search_product"
                                    id="live_search_product">
                            </select>
                        </div>
                    </div>
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
                                                <th>ID</th>
                                                <th>Product Name</th>
                                                <th>Category</th>
                                                <th>Brand</th>
                                                <th>Status</th>
                                                <th>Product Price</th>
                                                <th>Discount Percentage</th>
                                                <th>Discount Amount</th>
                                                <th>Selling Price</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody id="product-div">

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">
                                <em class="link-icon" data-feather="plus"></em>
                                Add Product
                            </button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@stop
