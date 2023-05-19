{!! Form::model($_product,['route'=>['admin.product.productTagSave',$_product->id],'method'=>'POST','id'=>'product_submit','class'=>'forms-sample']) !!}
<div class="row">
    <div class="col-lg-6 mb-3">
        <label class="form-label" for="tag_type">Product Tag</label>
        <div class="radio-put d-flex align-items-center align-middle pt-3">
            <div class="form-check form-check-inline">
                {!! Form::radio('tag_type', 'sale', $_product->tag_type ?? true,['class'=>'form-check-input' ,'id'=>'tag_type_sale']) !!}
                <label class="form-check-label" for="tag_type_sale">Sale</label>
            </div>
            <div class="form-check form-check-inline">
                {!! Form::radio('tag_type', 'new', $_product->tag_type ?? false,['class'=>'form-check-input' ,'id'=>'tag_type_new']) !!}
                <label class="form-check-label" for="tag_type_new">New</label>
            </div>
        </div>
    </div>
    <div class="col-lg-6 mb-3">
        <label for="tag_name" class="form-label"> Product Tag Name</label>
        {!! Form::text('tag_name', $value = old('tag_name'), ['id'=>'tag_name','placeholder'=>'Enter Product Tag Name','class'=>'form-control' ,"autocomplete"=>'off']) !!}
    </div>
</div>
<div class="row">
    <div class="text-center">
        <button type="submit" class="btn btn-primary">
            <em class="link-icon" data-feather="plus"></em>
            Save
        </button>
    </div>
</div>
{!! Form::close() !!}
