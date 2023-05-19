<div class="row">
    <div class="col-lg-12 mb-3">
        <label for="sliding_content_image" class="form-label">Upload Services Image</label>
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
        <label for="sub_title" class="form-label"> Sub Title</label>
        {!! Form::text('sub_title', $value = old('sub_title'), ['id'=>'sub_title','placeholder'=>'Enter Sub Title','class'=>'form-control']) !!}
        <span class="text-danger">{{ $errors->first('sub_title') }}</span>
    </div>
    <div class="text-center">
        <button type="submit" class="btn btn-primary"><i class="sub_title-icon" data-feather="plus"></i> {{$btn}}
        </button>
    </div>
</div>
