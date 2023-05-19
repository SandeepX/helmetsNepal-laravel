@if($section === 1)

    {!! Form::file('product_attributes_one_value[]',['id'=>'product_attributes_one_value','class'=>'form-control','multiple'=>'multiple']) !!}
    {!! Form::hidden('product_attributes_one',$value = 'image',['id'=>'product_attributes_one']) !!}
    @php
        $_productImages = json_decode($product_attributes_one_value ?? "") ?? [] ;
    @endphp
    <div class="row image-main d-flex align-items-center">
        @foreach($_productImages as $_productImage)
            <div class="col-lg-1 image-item position-relative" id="image_div_{{$_productImage}}">
                <img src="{{asset($product_attribute_image_path .'/'.$_productImage)}}" alt="product image" class="w-100 rounded">
                <a href="#" class="remove-product-attribute-image" image_div_id="image_div_{{$_productImage}}" productAttributeImage_id ="{{$_productImage}}" productAttributeDetail_id = "{{$productAttributeDetail_id}}" section = "1"><i class="link-icon" data-feather="x"></i></a>
            </div>
        @endforeach
    </div>
@elseif($section === 2)
    {!! Form::file('product_attributes_two_value[]',['id'=>'product_attributes_two_value','class'=>'form-control','multiple'=>'multiple']) !!}
    {!! Form::hidden('product_attributes_two',$value = 'image',['id'=>'product_attributes_two']) !!}
    @php
        $_productImages = json_decode($product_attributes_two_value ?? "") ?? [] ;
    @endphp
    <div class="row image-main d-flex align-items-center">
        @foreach($_productImages as $_productImage)
            <div class="col-lg-1 image-item position-relative" id="image_div_{{$_productImage}}">
                <img src="{{asset($product_attribute_image_path .'/'.$_productImage)}}" alt="product image" class="w-100 rounded">
                <a href="#" class="remove-product-attribute-image" image_div_id="image_div_{{$_productImage}}" productAttributeImage_id ="{{$_productImage}}"  productAttributeDetail_id = "{{$productAttributeDetail_id}}" section = "2"><i class="link-icon" data-feather="x"></i></a>
            </div>
        @endforeach
    </div>
@elseif($section === 3)
    {!! Form::file('product_attributes_three_value[]',['id'=>'product_attributes_three_value','class'=>'form-control','multiple'=>'multiple']) !!}
    {!! Form::hidden('product_attributes_three',$value = 'image',['id'=>'product_attributes_three']) !!}
    @php
        $_productImages = json_decode($product_attributes_three_value ?? "") ?? [] ;
    @endphp
    <div class="row image-main d-flex align-items-center">
        @foreach($_productImages as $_productImage)
            <div class="col-lg-1 image-item position-relative" id="image_div_{{$_productImage}}">
                <img src="{{asset($product_attribute_image_path .'/'.$_productImage)}}" alt="product image" class="w-100 rounded">
                <a href="#" class="remove-product-attribute-image" image_div_id="image_div_{{$_productImage}}" productAttributeImage_id ="{{$_productImage}}" productAttributeDetail_id = "{{$productAttributeDetail_id}}" section = "3"><i class="link-icon" data-feather="x"></i></a>
            </div>
        @endforeach
    </div>
@endif
