@if($section === 1)
    <div class="col-lg-12 mb-3">
        <label for="product_image" class="form-label">
            {!! Form::text('product_attributes_one', $value = ($product_attributes_one ?? null), ['id'=>'product_attributes_one','placeholder'=>'Enter Product attribute title','class'=>'form-control' ,"autocomplete"=>'off']) !!}
        </label>
        {!! Form::text('product_attributes_one_value', $value = (implode( "," , json_decode($product_attributes_one_value ?? "") ??[] )) ?? null, ['id'=>'product_attributes_one_value','class'=>'form-control tags-form-control' ,"autocomplete"=>'off']) !!}
    </div>

@elseif($section === 2)
    <div class="col-lg-12 mb-3">
        <label for="product_image" class="form-label">
            {!! Form::text('product_attributes_two', $value = ($product_attributes_two ?? null), ['id'=>'product_attributes_two','placeholder'=>'Enter Product attribute title','class'=>'form-control' ,"autocomplete"=>'off']) !!}
        </label>
        {!! Form::text('product_attributes_two_value', $value = (implode( "," , json_decode($product_attributes_two_value ?? "") ??[] )) ?? null, ['id'=>'product_attributes_two_value','class'=>'form-control tags-form-control-two' ,"autocomplete"=>'off']) !!}
    </div>
@elseif($section === 3)
    <div class="col-lg-12 mb-3">
        <label for="product_image" class="form-label">
            {!! Form::text('product_attributes_three', $value = ($product_attributes_three ?? null), ['id'=>'product_attributes_three','placeholder'=>'Enter Product attribute title','class'=>'form-control' ,"autocomplete"=>'off']) !!}
        </label>

        {!! Form::text('product_attributes_three_value', $value = (implode( "," , json_decode($product_attributes_three_value ?? "") ??[] )) ?? null, ['id'=>'product_attributes_three_value','class'=>'form-control tags-form-control-three' ,"autocomplete"=>'off']) !!}
    </div>
@endif

