<div class="row">
    <div class="col-lg-12 mb-3">
        <label for="title" class="form-label"> Title</label>
        {!! Form::text('title', $value = old('title'), ['id'=>'title','placeholder'=>'Enter Title','class'=>'form-control']) !!}
        <span class="text-danger">{{ $errors->first('title') }}</span>
    </div>
    <div class="col-lg-12 mb-3">
        <label for="image" class="form-label">Upload Image</label>
        {!! Form::file('image',['id'=>'image','class'=>'form-control']) !!}
        @if($_department ?? false)
            <a href="{{ $_department->image_path  }}" target="_blank">
                <img src="{{ $_department->image_path  }}" alt="{{ $_department->title }}" height="100px" width="100px">
            </a>
        @endif
        <span class="text-danger">{{ $errors->first('image') }}</span>
    </div>
    <div class="text-center">
        <button type="submit" class="btn btn-primary"><i class="link-icon" data-feather="plus"></i> {{$btn}}</button>
    </div>
</div>
