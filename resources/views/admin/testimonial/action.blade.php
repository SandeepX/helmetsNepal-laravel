<div class="row">
    <div class="col-lg-12 mb-3">
        <label for="testimonial_image" class="form-label">Upload Image</label>
        {!! Form::file('testimonial_image',['id'=>'testimonial_image','class'=>'form-control']) !!}
        @if($_testimonial ?? false)
            <a href="{{ $_testimonial->image_path  }}" target="_blank">
                <img src="{{ $_testimonial->image_path  }}" alt="{{ $_testimonial->title }}" height="100px" width="100px">
            </a>
        @endif
        <span class="text-danger">{{ $errors->first('testimonial_image') }}</span>
    </div>
    <div class="col-lg-6 mb-3">
        <label for="name" class="form-label"> Name</label>
        {!! Form::text('name', $value = old('name'), ['id'=>'name','placeholder'=>'Enter Name','class'=>'form-control']) !!}
        <span class="text-danger">{{ $errors->first('name') }}</span>
    </div>
    <div class="col-lg-12 mb-3">
        <label for="designation" class="form-label"> Designation</label>
        {!! Form::text('designation', $value = old('designation'), ['id'=>'name','placeholder'=>'Enter Designation','class'=>'form-control']) !!}
        <span class="text-danger">{{ $errors->first('designation') }}</span>
    </div>
    <div class="col-lg-12 mb-3">
        <label for="description" class="form-label"> Description</label>
        {!! Form::textarea('description', $value = old('description'), ['id'=>'summernote','placeholder'=>'Enter Description','class'=>'form-control' ,'row'=>20]) !!}
        <span class="text-danger">{{ $errors->first('description') }}</span>
    </div>
    <div class="text-center">
        <button type="submit" class="btn btn-primary"><i class="link-icon" data-feather="plus"></i> {{$btn}}</button>
    </div>
</div>
