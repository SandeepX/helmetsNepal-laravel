<div class="row">
    <div class="col-lg-12 mb-3">
        <label for="title" class="form-label"> Page Title</label>
        {!! Form::text('title', $value = old('title'), ['id'=>'title','placeholder'=>'Enter Page Title','class'=>'form-control']) !!}
        <span class="text-danger">{{ $errors->first('title') }}</span>
    </div>

    <div class="col-lg-12 mb-3">
        <label for="details" class="form-label"> Page Details</label>
        {!! Form::textarea('details', $value = old('details'), ['id'=>'summernote','placeholder'=>'Enter Page Details','class'=>'form-control' ,'row'=>20]) !!}
        <span class="text-danger">{{ $errors->first('details') }}</span>
    </div>
    <div class="col-lg-6 mb-3">
        <label for="meta_title" class="form-label"> Meta Title</label>
        {!! Form::text('meta_title', $value = old('meta_title'), ['id'=>'meta_title','placeholder'=>'Enter Meta Title','class'=>'form-control']) !!}
        <span class="text-danger">{{ $errors->first('meta_title') }}</span>
    </div>
    <div class="col-lg-6 mb-3">
        <label for="meta_keys" class="form-label"> Meta Key</label>
        {!! Form::text('meta_keys', $value = old('meta_keys'), ['id'=>'meta_keys','placeholder'=>'Enter Meta Key','class'=>'form-control']) !!}
        <span class="text-danger">{{ $errors->first('meta_keys') }}</span>
    </div>
    <div class="col-lg-6 mb-3">
        <label for="meta_description" class="form-label"> Meta description</label>
        {!! Form::text('meta_description', $value = old('meta_description'), ['id'=>'meta_description','placeholder'=>'Enter Meta description','class'=>'form-control']) !!}
        <span class="text-danger">{{ $errors->first('meta_description') }}</span>
    </div>
    <div class="col-lg-6 mb-3">
        <label for="alternate_text" class="form-label"> Alternate Text</label>
        {!! Form::text('alternate_text', $value = old('alternate_text'), ['id'=>'alternate_text','placeholder'=>'Enter Alternate Text','class'=>'form-control']) !!}
        <span class="text-danger">{{ $errors->first('alternate_text') }}</span>
    </div>
    <div class="text-center">
        <button type="submit" class="btn btn-primary"><em class="link-icon" data-feather="plus"></em> {{$btn}}</button>
    </div>
</div>
