<div class="row">
    <div class="col-lg-12 mb-3">
        <label for="title" class="form-label"> Name</label>
        {!! Form::text('name', $value = old('name'), ['id'=>'name','placeholder'=>'Enter Name','class'=>'form-control']) !!}
        <span class="text-danger">{{ $errors->first('name') }}</span>
    </div>
    <div class="col-lg-12 mb-3">
        <p class="mb-2">Status</p>
        <div class="radio-put d-flex align-items-center align-middle pt-3">
            <div class="form-check form-check-inline">
                {!! Form::radio('icons', 'home', false,['class'=>'form-check-input' ,'id'=>'home']) !!}
                <label class="form-check-label" for="icons_active">home</label>
            </div>
            <div class="form-check form-check-inline">
                {!! Form::radio('icons', 'shop', false,['class'=>'form-check-input' ,'id'=>'shop']) !!}
                <label class="form-check-label" for="icons_inactive">shop</label>
            </div>
            <div class="form-check form-check-inline">
                {!! Form::radio('icons', 'lock', false,['class'=>'form-check-input' ,'id'=>'lock']) !!}
                <label class="form-check-label" for="icons_inactive">lock</label>
            </div>
        </div>
        <span class="text-danger">{{ $errors->first('icons') }}</span>
    </div>
    <div class="text-center">
        <button type="submit" class="btn btn-primary"><em class="link-icon" data-feather="plus"></em> {{$btn}}</button>
    </div>
</div>
