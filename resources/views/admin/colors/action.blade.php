<div class="row">
    <div class="col-lg-12 mb-3">
        <label for="title" class="form-label"> Name</label>
        {!! Form::text('name', $value = old('name'), ['id'=>'name','placeholder'=>'Enter Name','class'=>'form-control']) !!}
        <span class="text-danger">{{ $errors->first('name') }}</span>
    </div>
    <div class="col-lg-12 mb-3">
        <label for="color" class="form-label"> Pick Color</label>
        {!! Form::color('color_value', $value = old('color_value'), ['id'=>'color_value','placeholder'=>'Pick Color','class'=>'form-control form-control-color']) !!}
        <span class="text-danger">{{ $errors->first('color_value') }}</span>
    </div>
    <div class="text-center">
        <button type="submit" class="btn btn-primary"><i class="link-icon" data-feather="plus"></i> {{$btn}}</button>
    </div>
</div>
