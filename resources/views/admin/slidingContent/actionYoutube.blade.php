<div class="row">
    <div class="col-lg-12 mb-3">
        <label for="sliding_content_image" class="form-label">Upload Youtube Slider Image</label>
        {!! Form::file('sliding_content_image',['id'=>'sliding_content_image','class'=>'form-control']) !!}
        @if($_slidingContent ?? false)
            <a href="{{ $_slidingContent->image_path }}" target="_blank">
                <img src="{{ $_slidingContent->image_path  }}" alt="{{ $_slidingContent->title }}" height="100px"
                     width="100px">
            </a>
        @endif
        <span class="text-danger">{{ $errors->first('sliding_content_image') }}</span>
    </div>
    <div class="col-lg-12 mb-3">
        <label for="title" class="form-label"> Title</label>
        {!! Form::text('title', $value = old('title'), ['id'=>'title','placeholder'=>'Enter Title','class'=>'form-control']) !!}
        <span class="text-danger">{{ $errors->first('title') }}</span>
    </div>
    <div class="col-lg-12 mb-3">
        <label for="youtube_link" class="form-label"> Youtube Link</label>
        {!! Form::text('youtube_link', $value = old('youtube_link'), ['id'=>'youtube_link','placeholder'=>'Enter Youtube Link','class'=>'form-control']) !!}
        <span class="text-danger">{{ $errors->first('youtube_link') }}</span>
    </div>
    <div class="text-center">
        <button type="submit" class="btn btn-primary"><i class="sub_title-icon" data-feather="plus"></i> {{$btn}}
        </button>
    </div>
</div>
