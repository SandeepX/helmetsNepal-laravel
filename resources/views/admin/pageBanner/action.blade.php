<div class="row">
    <div class="col-lg-12 mb-3">
        <label for="user_image" class="form-label">Upload Page Banner Image</label>
        {!! Form::file('page_image',['id'=>'page_image','class'=>'form-control']) !!}
        @if($_pageBanner ?? false)
            <a href="{{ $_pageBanner->page_image_path  }}" target="_blank">
                <img src="{{ $_pageBanner->page_image_path  }}" alt="{{ $_pageBanner->page_title }}" height="100px" width="100px">
            </a>

        @endif
        <span class="text-danger">{{ $errors->first('page_image') }}</span>
    </div>
    <div class="col-lg-6 mb-3">
        <label for="page_title" class="form-label">Page Title</label>
        {!! Form::text('page_title', $value = old('page_title'), ['id'=>'page_title','placeholder'=>'Enter Title','class'=>'form-control']) !!}
        <span class="text-danger">{{ $errors->first('page_title') }}</span>
    </div>
    <div class="col-lg-6 mb-3">
        <label for="page_sub_title" class="form-label">Page Sub Title</label>
        {!! Form::text('page_sub_title', $value = old('page_sub_title'), ['id'=>'page_sub_title','placeholder'=>'Enter Sub Title','class'=>'form-control']) !!}
        <span class="text-danger">{{ $errors->first('page_sub_title') }}</span>
    </div>
    <div class="col-lg-6 mb-3">
        <label for="page_title_description" class="form-label"> Page Title Description</label>
        {!! Form::textarea('page_title_description', $value = old('page_title_description'), ['id'=>'page_title_description','placeholder'=>'Enter Page Title Description','class'=>'form-control']) !!}
        <span class="text-danger">{{ $errors->first('page_title_description') }}</span>
    </div>
    <div class="text-center">
        <button type="submit" class="btn btn-primary"><i class="link-icon" data-feather="plus"></i> {{$btn}}</button>
    </div>
</div>
