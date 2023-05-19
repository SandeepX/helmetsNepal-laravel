<div class="row">
    <div class="col-lg-12 mb-3">
        <label for="user_image" class="form-label">Upload Brand Image</label>
        {!! Form::file('brand_image',['id'=>'brand_image','class'=>'form-control']) !!}
        @if($_brand ?? false)
            <a href="{{ $_brand->image_path  }}" target="_blank">
                <img src="{{ $_brand->image_path  }}" alt="{{ $_brand->title }}" height="100px" width="100px">
            </a>

        @endif
        <span class="text-danger">{{ $errors->first('brand_image') }}</span>
    </div>
    <div class="col-lg-6 mb-3">
        <label for="title" class="form-label"> Title</label>
        {!! Form::text('title', $value = old('title'), ['id'=>'title','placeholder'=>'Enter Title','class'=>'form-control']) !!}
        <span class="text-danger">{{ $errors->first('title') }}</span>
    </div>
    <div class="col-lg-6 mb-3">
        <label for="link" class="form-label"> Link</label>
        {!! Form::text('link', $value = old('link'), ['id'=>'link','placeholder'=>'Enter Link','class'=>'form-control']) !!}
        <span class="text-danger">{{ $errors->first('link') }}</span>
    </div>
    <div class="col-lg-6 mb-3">
        <label for="description" class="form-label"> Description</label>
        {!! Form::textarea('description', $value = old('description'), ['id'=>'description','placeholder'=>'Enter Description','class'=>'form-control']) !!}
        <span class="text-danger">{{ $errors->first('description') }}</span>
    </div>
    <div class="text-center">
        <button type="submit" class="btn btn-primary"><i class="link-icon" data-feather="plus"></i> {{$btn}}</button>
    </div>
</div>
