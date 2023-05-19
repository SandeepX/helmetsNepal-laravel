<div class="row">
    <div class="col-lg-12 mb-3">
        <label for="title" class="form-label"> Name</label>
        {!! Form::text('name', $value = old('name'), ['id'=>'name','placeholder'=>'Enter Name','class'=>'form-control']) !!}
        <span class="text-danger">{{ $errors->first('name') }}</span>
    </div>
    <div class="text-center">
        <button type="submit" class="btn btn-primary"><em class="link-icon" data-feather="plus"></em> {{$btn}}</button>
    </div>
</div>
