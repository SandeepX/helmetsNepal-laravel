<div class="row">
    <div class="col-lg-12 mb-3">
        <label for="riderStory_image" class="form-label">Upload Image</label>
        {!! Form::file('riderStory_image',['id'=>'riderStory_image','class'=>'form-control']) !!}
        @if($_riderStory ?? false)
            <a href="{{ $_riderStory->image_path  }}" target="_blank">
                <img src="{{ $_riderStory->image_path  }}" alt="{{ $_riderStory->title }}" height="100px" width="100px">
            </a>
        @endif
        <span class="text-danger">{{ $errors->first('riderStory_image') }}</span>
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
        <label for="quote" class="form-label"> Quote </label>
        {!! Form::textarea('quote', $value = old('quote'), ['id'=>'quote','placeholder'=>'Enter Quote','class'=>'form-control' ,'row' => 4]) !!}
        <span class="text-danger">{{ $errors->first('quote') }}</span>
    </div>
    <div class="col-lg-12 mb-3">
        <label for="description" class="form-label"> Details Description</label>
        {!! Form::textarea('description', $value = old('description'), ['id'=>'summernote','placeholder'=>'Enter Details Description','class'=>'form-control']) !!}
        <span class="text-danger">{{ $errors->first('description') }}</span>
    </div>
    <div class="text-center">
        <button type="submit" class="btn btn-primary"><i class="link-icon" data-feather="plus"></i> {{$btn}}</button>
    </div>
</div>
