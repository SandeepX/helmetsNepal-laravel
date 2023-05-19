<div class="row">
    <div class="col-lg-12 mb-3">
        <label for="user_image" class="form-label">Upload Banner Image</label>
        {!! Form::file('banner_image',['id'=>'banner_image','class'=>'form-control']) !!}
        @if($_banner ?? false)
            <a href="{{ $_banner->image_path  }}" target="_blank">
                <img src="{{ $_banner->image_path  }}" alt="{{ $_banner->title }}" height="100px" width="100px">
            </a>

        @endif
        <span class="text-danger">{{ $errors->first('banner_image') }}</span>
    </div>
    <div class="col-lg-6 mb-3">
        <label for="title" class="form-label"> Title</label>
        {!! Form::text('title', $value = old('title'), ['id'=>'title','placeholder'=>'Enter Title','class'=>'form-control']) !!}
        <span class="text-danger">{{ $errors->first('title') }}</span>
    </div>
    <div class="col-lg-6 mb-3">
        <label for="sub_title" class="form-label"> Sub Title</label>
        {!! Form::text('sub_title', $value = old('sub_title'), ['id'=>'sub_title','placeholder'=>'Enter Sub Title','class'=>'form-control']) !!}
        <span class="text-danger">{{ $errors->first('sub_title') }}</span>
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
