<div class="row">
    <div class="col-lg-2 mb-3">
        <label for="barcode" class="form-label">Barcode</label>
        {!! Form::text('barcode[]', $value = old('barcode'), ['id'=>'barcode','placeholder'=>'Enter Barcode','class'=>'form-control' ,"autocomplete"=>'off']) !!}
    </div>
    <div class="col-lg-2 mb-3">
        <label class="form-label" for="color_id_1">Color</label>
        <div>
            {!! Form::select('color_id_1[]',$_colorSelectList, $value = old('color_id_1'), ['id'=>'color_id_1','class'=>'form-select','placeholder'=>'Select Color']) !!}
        </div>
    </div>
    <div class="col-lg-2 mb-3">
        <label class="form-label" for="color_gradient">Color Gradient Status</label>
        <div class="radio-put d-flex align-items-center align-middle pt-3">
            <div class="form-check form-check-inline">
                <input type="radio" name="color_gradient[{{$index_value}}]" value="1" class="form-check-input color_gradient">
                <label class="form-check-label">Yes</label>
            </div>
            <div class="form-check form-check-inline">
                <input type="radio" name="color_gradient[{{$index_value}}]" value="0" class="form-check-input color_gradient"
                       checked>
                <label class="form-check-label">No</label>
            </div>
        </div>
    </div>
    <div class="col-lg-2 mb-3 color_gradient_div" style="display: none">
        <label class="form-label" for="color_id_2">Color Gradient </label>
        <div>
            {!! Form::select('color_id_2[]',$_colorSelectList, $value = old('color_id_2'), ['id'=>'color_id_2','class'=>'form-select','placeholder'=>'Select Color Gradient']) !!}
        </div>
    </div>
    <div class="col-lg-2 mb-3">
        <label for="product_image_color" class="form-label">Product Color Image</label>
        {!! Form::file('product_image_color[]',['id'=>'product_image_color','class'=>'form-control']) !!}
    </div>
    <div class="col-lg-2 mb-3">
        <label for="quantity" class="form-label">Quantity</label>
        {!! Form::number('quantity[]', $value = old('quantity'), ['id'=>'quantity','placeholder'=>'Enter Quantity','class'=>'form-control' ,"autocomplete"=>'off']) !!}
    </div>
    <div class="col-lg-1 mb-3">
        <button type="button" class="btn btn-primary delete-div">
            remove
        </button>
    </div>
</div>
