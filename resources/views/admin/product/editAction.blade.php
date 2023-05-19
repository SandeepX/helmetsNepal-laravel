<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="mb-4">Add Product</h4>
                <form class="forms-sample">
                    <div class="row">
                        <hr>
                        <h5 class="mb-4 border-bottom">Product basic info</h5>
                        <div class="col-lg-6 mb-3">
                            <label for="title" class="form-label"> Product title</label>
                            {!! Form::text('title', $value = old('title'), ['id'=>'title','placeholder'=>'Enter Product title','class'=>'form-control' ,"autocomplete"=>'off']) !!}
                            <span class="text-danger">{{ $errors->first('title') }}</span>
                        </div>
                        `
                        <div class="col-lg-6 mb-3">
                            <label for="sub_title" class="form-label"> Product sub-title</label>
                            {!! Form::text('sub_title', $value = old('sub_title'), ['id'=>'sub_title','placeholder'=>'Enter Product sub title','class'=>'form-control' ,"autocomplete"=>'off']) !!}
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label for="product_code" class="form-label"> Product Code</label>
                            {!! Form::text('product_code', $value = old('product_code'), ['id'=>'product_code','placeholder'=>'Enter Product Code','class'=>'form-control' ,"autocomplete"=>'off']) !!}
                            <span class="text-danger">{{ $errors->first('product_code') }}</span>
                        </div>
                        <div class="col-lg-12 mb-3">
                            <label for="cover_image" class="form-label"> Product Cover Image</label>
                            {!! Form::file('cover_image',['id'=>'cover_image','class'=>'form-control']) !!}
                            <a href="{{ $_product->product_cover_image_path  }}" target="_blank">
                                <img src="{{ $_product->product_cover_image_path  }}" alt="{{ $_product->title }}"
                                     height="100px" width="100px">
                            </a>
                            <span class="text-danger">{{ $errors->first('cover_image') }}</span>
                        </div>
                    </div>
                    <div class="row">
                        <hr>
                        <h5 class="mb-4 border-bottom">Product category details</h5>
                        <div class="col-lg-4 mb-3">
                            <label for="main_category_id" class="form-label"> Select Main Category</label>
                            {!! Form::select('main_category_id',$_categorySelectList, $value = $_productCategoryDetails['main_category_id'], ['id'=>'main_category_id','class'=>'form-select main_category','placeholder'=>'Select Category']) !!}
                            <span class="text-danger">{{ $errors->first('main_category_id') }}</span>
                        </div>
                        <div class="col-lg-4 mb-3 parent_category_id_div"
                             @if(!$_productCategoryDetails['parent_category_id']) style="display: none" @endif >
                            <label for="parent_category_id" class="form-label"> Select Parent Category</label>
                            {!! Form::select('parent_category_id',$_productCategoryDetails['parent_cat_list'], $value = $_productCategoryDetails['parent_category_id'], ['id'=>'parent_category_id','class'=>'form-select parent_category','placeholder'=>'Select Category']) !!}
                            <span class="text-danger">{{ $errors->first('parent_category_id') }}</span>
                        </div>
                        <div class="col-lg-4 mb-3 category_id_div"
                             @if(!$_productCategoryDetails['category_id']) style="display: none" @endif >
                            <label for="category_id" class="form-label"> Select Category</label>
                            {!! Form::select('category_id',$_productCategoryDetails['cat_list'], $value = $_productCategoryDetails['category_id'], ['id'=>'category_id','class'=>'form-select category','placeholder'=>'Select Category']) !!}
                        </div>
                        <hr>
                        <div class="col-lg-3 mb-3">
                            <label for="brand_id" class="form-label"> Select Brand</label>
                            {!! Form::select('brand_id',$_brandSelectList, $value = old('brand_id'), ['id'=>'brand_id','class'=>'form-select','placeholder'=>'Select Brand']) !!}
                        </div>
                        <div class="col-lg-3 mb-3">
                            <label for="brand_id" class="form-label"> Select Product Graphic</label>
                            {!! Form::select('product_graphic_id',$_productGraphicSelectList, $value = old('product_graphic_id'), ['id'=>'brand_id','class'=>'form-select','placeholder'=>'Select Product Graphic']) !!}
                        </div>
                        <div class="col-lg-3 mb-3">
                            <label for="brand_id" class="form-label"> Select Product Model</label>
                            {!! Form::select('product_model_id',$_productModelSelectList, $value = old('product_model_id'), ['id'=>'brand_id','class'=>'form-select','placeholder'=>'Select Product Model']) !!}
                        </div>
                        <div class="col-lg-3 mb-3">
                            <label for="manufacture_id" class="form-label"> Select Product Manufacture</label>
                            {!! Form::select('manufacture_id',$_manufactureSelectList, $value = old('manufacture_id'), ['id'=>'manufacture_id','class'=>'form-select','placeholder'=>'Select Product Manufacture']) !!}
                        </div>
                    </div>
                    <div class="row">
                        <hr>
                        <h5 class="mb-4 border-bottom">Product Price Details</h5>
                        <div class="col-lg-4 mb-3">
                            <label for="product_price" class="form-label"> Product Price</label>
                            {!! Form::text('product_price', $value = old('product_price'), ['id'=>'product_price','placeholder'=>'Enter Product Price','class'=>'form-control' ,"autocomplete"=>'off']) !!}
                        </div>
                    </div>
                    <div class="row">
                        <hr>
                        <h5 class="mb-4 border-bottom">Product Identification</h5>
                        <div class="col-lg-2 mb-3">
                            <label for="sku" class="form-label"> sku</label>
                            {!! Form::text('sku', $value = old('sku'), ['id'=>'product_price','placeholder'=>'Enter sku','class'=>'form-control' ,"autocomplete"=>'off']) !!}
                        </div>
                    </div>
                    <div class="row">
                        <hr>
                        <h5 class="mb-4 border-bottom">Product Meta Details</h5>
                        <div class="col-lg-3 mb-3">
                            <label for="meta_title" class="form-label"> Meta Title</label>
                            {!! Form::text('meta_title', $value = old('title'), ['id'=>'meta_title','placeholder'=>'Enter Meta Title','class'=>'form-control' ,"autocomplete"=>'off']) !!}
                        </div>
                        <div class="col-lg-3 mb-3">
                            <label for="meta_keys" class="form-label"> Meta Keys</label>
                            {!! Form::text('meta_keys', $value = old('meta_keys'), ['id'=>'meta_keys','placeholder'=>'Enter Meta Keys','class'=>'form-control' ,"autocomplete"=>'off']) !!}
                        </div>
                        <div class="col-lg-3 mb-3">
                            <label for="meta_description" class="form-label"> Meta description</label>
                            {!! Form::text('meta_description', $value = old('meta_description'), ['id'=>'meta_description','placeholder'=>'Meta description','class'=>'form-control' ,"autocomplete"=>'off']) !!}
                        </div>
                        <div class="col-lg-3 mb-3">
                            <label for="alternate_text" class="form-label"> Alternate Text</label>
                            {!! Form::text('alternate_text', $value = old('alternate_text'), ['id'=>'alternate_text','placeholder'=>'Enter Alternate Text','class'=>'form-control' ,"autocomplete"=>'off']) !!}
                        </div>
                    </div>
                    <div class="row">
                        <hr>
                        <h5 class="mb-4 border-bottom">Product Details</h5>
                        {{--                        <div class="col-lg-6 mb-3">--}}
                        {{--                            <label for="short_details" class="form-label"> Short description</label>--}}
                        {{--                            {!! Form::textarea('short_details', $value = old('short_details'), ['id'=>'short_details','placeholder'=>'Enter Short description','class'=>'form-control','rows'=>'10' ,"autocomplete"=>'off']) !!}--}}
                        {{--                        </div>--}}

                        <div class="col-lg-12 mb-3">
                            <label for="details" class="form-label"> Full description</label>
                            {!! Form::textarea('details', $value = old('details'), ['id'=>'summernote','placeholder'=>'Enter Full description','class'=>'form-control','rows'=>'10' ,"autocomplete"=>'off']) !!}
                            <span class="text-danger">{{ $errors->first('details') }}</span>
                        </div>
                    </div>
                    <div class="row">
                        <hr>
                        <h5 class="mb-4 border-bottom">Product Size</h5>
                        <div class="col-lg-4 mb-3">
                            <label class="form-label" for="size_status">Product Size Status</label>
                            <div class="radio-put d-flex align-items-center align-middle pt-3">
                                <div class="form-check form-check-inline">
                                    {!! Form::radio('size_status', 1, false,['class'=>'form-check-input' ,'id'=>'size_status_yes']) !!}
                                    <label class="form-check-label" for="size_status_yes">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    {!! Form::radio('size_status', 0, true,['class'=>'form-check-input' ,'id'=>'size_status_no']) !!}
                                    <label class="form-check-label" for="size_status_no">No</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8 mb-3 "
                             style="display: @if($_product->size_status) block @else none @endif" id="size-div">
                            <label class="form-label" for="product_size_id">Size</label>
                            <div>
                                @foreach($_sizeSelectList as $size_id => $size)
                                    <div class="form-check form-check-inline">
                                        <input type="checkbox" class="form-check-input" name="product_size_id[]"
                                               value="{{$size_id}}"
                                               @if(in_array($size_id, $product_size, true)) checked @endif>
                                        <label class="form-check-label">{{$size}}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <hr>
                        <h5 class="mb-4 border-bottom">Product Custom Attribute</h5>
                        <div class="col-lg-3 mb-3">
                            <label class="form-label" for="custom_status">Product Custom Attribute Status</label>
                            <div class="radio-put d-flex align-items-center align-middle pt-3">
                                <div class="form-check form-check-inline">
                                    {!! Form::radio('custom_status', 1, true,['class'=>'form-check-input' ,'id'=>'custom_status_yes']) !!}
                                    <label class="form-check-label" for="custom_status_yes">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    {!! Form::radio('custom_status', 0, true,['class'=>'form-check-input' ,'id'=>'custom_status_no']) !!}
                                    <label class="form-check-label" for="custom_status_no">No</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 mb-3 custom-div"
                             style="display: @if($_product->custom_status) block @else none @endif ">
                            <label for="product_custom_attributes" class="form-label"> Product Custom Attribute
                                Title</label>
                            {!! Form::text('product_custom_attributes', $value = ($product_custom->product_custom_attributes ?? old('product_custom_attributes')), ['id'=>'product_custom_attributes','placeholder'=>'Enter Product Custom Attribute Title','class'=>'form-control' ,"autocomplete"=>'off']) !!}
                        </div>
                        <div class="col-lg-6 mb-3 custom-div"
                             style="display: @if($_product->custom_status) block @else none @endif ">
                            <label for="product_custom_attribute_value" class="form-label"> Product Custom Attribute
                                Value</label>
                            {!! Form::text('product_custom_attribute_value', $value = ($product_custom->product_custom_attribute_value ?? old('product_custom_attribute_value')), ['id'=>'product_custom_attribute_value','placeholder'=>'Enter Product Custom Attribute Value','class'=>'tags-form-control']) !!}
                        </div>
                    </div>
                    <div class="row">
                        <h5 class="mb-4 border-bottom">For vendor</h5>
                        <hr>
                        <div class="col-lg-6 mb-3">
                            <label for="minimum_quantity" class="form-label"> Minimum Order Quantity For vendor</label>
                            {!! Form::number('minimum_quantity', $value = old('minimum_quantity'), ['id'=>'minimum_quantity','placeholder'=>'Enter Minimum Order  Quantity For vendor','class'=>'form-control' ,"autocomplete"=>'off']) !!}
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label for="vendor_price" class="form-label"> Product Price for vendor</label>
                            {!! Form::number('vendor_price', $value = old('vendor_price'), ['id'=>'vendor_price','placeholder'=>'Enter  Product Price for vendor','class'=>'form-control' ,"autocomplete"=>'off']) !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary"><em class="link-icon"
                                                                              data-feather="plus"></em>
                                Update Product
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

