@extends('admin.master')

@section('title')
    {{$_feature_category->name}}
@stop
@section('page_title')
    List
@stop
@section('action_button')
    @include('admin.include.addButton',[ 'route' => route('admin.featureCategory.createFeatureCategory', ['feature_category'=> $_feature_category->slug]), 'button_text' => "Create " . $_feature_category->name])
@stop
@section('js')
<script>
    $(document).ready(function () {
        $('.uploadImageModel').on('click', function () {
            var link = $(this).attr('link');
            console.log(link);
            $('.get_link').attr('action', link);
        });
    });
</script>
@stop
@section('content')
    @if($is_flash_sale)
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="mb-4">Flash Sale Setup</h4>
                    {!! Form::open(['route'=>['admin.feature-category.updateFlashSale',['feature_category'=>$_feature_category->slug]],'method'=>'POST','id'=>'featureCategory_submit' ,'class'=>'forms-sample']) !!}
                    <div class="row">
                        <div class="col-lg-6 mb-3">
                            <label for="sale_start_date" class="form-label"> Sale Start Date</label>
                            <input type="datetime-local" name="sale_start_date" id="sale_start_date" class="form-control" value="{{$_feature_category->sale_start_date}}"  required>
                            <span class="text-danger">{{ $errors->first('sale_start_date') }}</span>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label for="sale_end_date" class="form-label"> Sale End Date</label>
                            <input type="datetime-local" name="sale_end_date" id="sale_end_date" class="form-control" value="{{$_feature_category->sale_end_date}}" required>
                            <span class="text-danger">{{ $errors->first('sale_end_date') }}</span>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary"><em class="link-icon" data-feather="plus"></em> Update Flash Sale Date and Time</button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
    @endif
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="mb-4">{{$_feature_category->name}} List</h4>
                    <div class="row">
                        <div class="col-md-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="dataTableExample" class="table">
                                            <caption>{{$_feature_category->name}} List</caption>
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>ID</th>
                                                <th>Product Name</th>
                                                @if($is_flash_sale)
                                                    <th>Feature Image</th>
                                                @endif
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
                                            @foreach( $featureCategoryItem as $_product)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{$_product->product_code}}</td>
                                                    <td>{{$_product->title}}</td>
                                                    @if($is_flash_sale)
                                                        <td>
                                                            <img src="{{asset('/front/uploads/feature_category/' . $_product->feature_category_image)}}" alt=" {{ $_product->product_code }}">
                                                        </td>
                                                    @endif
                                                    <td>{{$_product->category_name}}</td>
                                                    <td>{{$_product->brand_name ?? "-"}}</td>
                                                    <td>{{ ucfirst($_product->status)}}</td>

                                                    <td>{{$_product->product_price}}</td>
                                                    <td>{{$_product->discount_percent?? 0.0}}%
                                                    </td>
                                                    <td>{{$_product->discount_amount}}</td>
                                                    <td>{{$_product->final_product_price}}</td>
                                                    <td>
                                                        <ul class="d-flex list-unstyled mb-0">
                                                            @if($is_flash_sale)
                                                            <li>
                                                                <a class="uploadImageModel" data-bs-toggle="modal"
                                                                   data-bs-target="#uploadImageModel"
                                                                   link='{{route('admin.featureCategory.uploadImageFeatureCategoryItem',['feature_category_item_id'=>$_product->feature_category_item_id , 'feature_category'=>$_feature_category->slug])}}'>
                                                                    <em class="link-icon" data-feather="image"></em>
                                                                </a>
                                                            </li>
                                                            @endif
                                                            <li>
                                                                <a class="delete-modal" data-bs-toggle="modal"
                                                                   data-bs-target="#deleteModel"
                                                                   link='{{route('admin.featureCategory.deleteFeatureCategoryItem',['feature_category_item_id'=>$_product->feature_category_item_id , 'feature_category'=>$_feature_category->slug])}}'>
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
                </div>
            </div>
        </div>
    </div>
    @include('admin.include.delete-model')

    <div class="modal fade" id="uploadImageModel" tabindex="-1" aria-labelledby="uploadImageModel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h5 class="modal-title" id="exampleModalLabel">Upload Image </h5>
                </div>
                <div class="modal-body">
                    {!! Form::open(['method'=>'POST','class'=>'get_link','files' => true]) !!}
                    <div class="row">
                        <div class="col-lg-12 mb-3">
                            <label for="title" class="form-label"> Upload Images</label>
                            {!! Form::file('images', $value = old('images'), ['id'=>'images','class'=>'form-control']) !!}
                            <span class="text-danger">{{ $errors->first('detail') }}</span>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary"><em class="link-icon" data-feather="plus"></em> Upload Images</button>
                        </div>
                    </div>
                    <a href="javascript:void(0);" data-dismiss="modal" class="btn btn-primary cancel-btn">Cancel</a>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@stop
