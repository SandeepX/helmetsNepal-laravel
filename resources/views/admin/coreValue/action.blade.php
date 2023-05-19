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
        <label for="png_image" class="form-label">Upload PNG Image</label>
        {!! Form::file('png_image',['id'=>'png_image','class'=>'form-control']) !!}
        @if($_coreValue ?? false)
            <a href="{{ $_coreValue->image_path  }}" target="_blank">
                <img src="{{ $_coreValue->image_path  }}" alt="{{ $_coreValue->title }}" height="100px" width="100px">
            </a>
        @endif
        <span class="text-danger">{{ $errors->first('png_image') }}</span>
    </div>
    <div class="text-center">
        <button type="submit" class="btn btn-primary"><i class="link-icon" data-feather="plus"></i> {{$btn}}</button>
    </div>
</div>
