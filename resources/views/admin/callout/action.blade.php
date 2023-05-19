<div class="row">
    <div class="col-lg-12 mb-3">
        <label for="title" class="form-label"> Title</label>
        {!! Form::text('title', $value = old('title'), ['id'=>'title','placeholder'=>'Enter Title','class'=>'form-control']) !!}
        <span class="text-danger">{{ $errors->first('title') }}</span>
    </div>
    <div class="col-lg-12 mb-3">
        <label for="description" class="form-label"> Description</label>
        {!! Form::textarea('description', $value = old('description'), ['id'=>'description','placeholder'=>'Enter Description','class'=>'form-control']) !!}
        <span class="text-danger">{{ $errors->first('description') }}</span>
    </div>
    <div class="col-lg-12 mb-3">
        <label for="image" class="form-label">Upload PNG Image</label>
        {!! Form::file('image',['id'=>'image','class'=>'form-control']) !!}
        @if($_coreValue ?? false)
            <a href="{{ $_coreValue->image_path  }}" target="_blank">
                <img src="{{ $_coreValue->image_path  }}" alt="{{ $_coreValue->title }}" height="100px" width="100px">
            </a>
        @endif
        <span class="text-danger">{{ $errors->first('image') }}</span>
    </div>

    <div class="col-lg-12 mb-3">
        <label for="image" class="form-label">Show In</label>
        <div class="radio-put d-flex align-items-center align-middle pt-3">
            <div class="form-check form-check-inline">
                {!! Form::radio('type', 'about_us', false,['class'=>'form-check-input' ,'id'=>'about_us']) !!}
                <label class="form-check-label" for="type_yes">About Us</label>
            </div>
            <div class="form-check form-check-inline">
                {!! Form::radio('type', 'shop', true,['class'=>'form-check-input' ,'id'=>'shop']) !!}
                <label class="form-check-label" for="shop">Shop</label>
            </div>
        </div>
        <span class="text-danger">{{ $errors->first('type') }}</span>
    </div>


    <div class="text-center">
        <button type="submit" class="btn btn-primary"><i class="link-icon" data-feather="plus"></i> {{$btn}}</button>
    </div>
</div>
