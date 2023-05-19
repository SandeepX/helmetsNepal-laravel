<div class="row">
    <div class="col-lg-12 mb-3">
        <label for="blog_category_id" class="form-label"> Select Blog Category</label>
        {!! Form::select('blog_category_id',$_blogCategory, $value = old('blog_category_id'), ['id'=>'blog_category_id','class'=>'form-select','placeholder'=>'Select Blog Category']) !!}
        <span class="text-danger">{{ $errors->first('blog_category_id') }}</span>
    </div>
    <div class="col-lg-12 mb-3">
        <label for="title" class="form-label">Blog Title</label>
        {!! Form::textarea('title', $value = old('title'), ['id'=>'title','placeholder'=>'Enter Blog Title','class'=>'form-control']) !!}
        <span class="text-danger">{{ $errors->first('title') }}</span>
    </div>
    <div class="col-lg-12 mb-3">
        <label for="blog_image" class="form-label">Upload Blog Image</label>
        {!! Form::file('blog_image',['id'=>'blog_image','class'=>'form-control']) !!}
        @if($_blog ?? false)
            <a href="{{ $_blog->blog_image_path  }}" target="_blank">
                <img src="{{ $_blog->blog_image_path  }}" alt="{{ $_blog->title }}" height="100px" width="100px">
            </a>

        @endif
        <span class="text-danger">{{ $errors->first('blog_image') }}</span>
    </div>
    <div class="col-lg-6 mb-3">
        <label for="blog_created_by" class="form-label">Blog Created By</label>
        {!! Form::text('blog_created_by', $value = old('blog_created_by'), ['id'=>'blog_created_by','placeholder'=>'Enter Blog Created By','class'=>'form-control']) !!}
        <span class="text-danger">{{ $errors->first('blog_created_by') }}</span>
    </div>
    <div class="col-lg-6 mb-3">
        <label for="blog_creator_image" class="form-label">Upload Blog creator image</label>
        {!! Form::file('blog_creator_image',['id'=>'blog_creator_image','class'=>'form-control']) !!}
        @if($_blog ?? false)
            <a href="{{ $_blog->blog_creator_image_path  }}" target="_blank">
                <img src="{{ $_blog->blog_creator_image_path  }}" alt="{{ $_blog->blog_creator_image }}" height="100px" width="100px">
            </a>

        @endif
        <span class="text-danger">{{ $errors->first('blog_creator_image') }}</span>
    </div>
    <div class="col-lg-6 mb-3">
        <label for="blog_read_time" class="form-label">Blog Read Time</label>
        {!! Form::text('blog_read_time', $value = old('blog_read_time'), ['id'=>'blog_read_time','placeholder'=>'Enter Blog Read Time','class'=>'form-control']) !!}
        <span class="text-danger">{{ $errors->first('blog_read_time') }}</span>
    </div>
    <div class="col-lg-6 mb-3">
        <label for="blog_publish_date" class="form-label">Blog Published Date</label>
        <div class="input-group date datepicker" id="blog_publish_date_input">
            {!! Form::text('blog_publish_date', $value = old('blog_publish_date'), ['id'=>'blog_publish_date','class'=>'form-control']) !!}
            <span class="input-group-text input-group-addon"><i data-feather="calendar"></i></span>
        </div>
        <span class="text-danger">{{ $errors->first('blog_publish_date') }}</span>
    </div>
    <div class="col-lg-12 mb-3">
        <label for="description" class="form-label"> Description</label>
        {!! Form::textarea('description', $value = old('description'), ['id'=>'summernote','placeholder'=>'Enter Description','class'=>'form-control']) !!}
        <span class="text-danger">{{ $errors->first('description') }}</span>
    </div>
    <div class="text-center">
        <button type="submit" class="btn btn-primary"><em class="link-icon" data-feather="plus"></em> {{$btn}}</button>
    </div>
</div>
