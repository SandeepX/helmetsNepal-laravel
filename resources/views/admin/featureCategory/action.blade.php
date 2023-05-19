<div class="row">
    <div class="col-lg-12 mb-3">
        <label for="title" class="form-label"> Name</label><p>{{$_featureCategory->name}}</p>
    </div>

    <div class="col-lg-12 mb-3">
        <label for="title" class="form-label"> Detail (Section detail)</label>
        {!! Form::text('detail', $value = old('detail'), ['id'=>'detail','placeholder'=>'Enter Detail (Section detail)','class'=>'form-control']) !!}
        <span class="text-danger">{{ $errors->first('detail') }}</span>
    </div>
    <div class="text-center">
        <button type="submit" class="btn btn-primary"><em class="link-icon" data-feather="plus"></em> {{$btn}}</button>
    </div>
</div>
