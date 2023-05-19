<div class="row">
    <div class="col-lg-6 mb-3">
        <label for="name" class="form-label"> Name</label>
        {!! Form::text('name', $value = old('name'), ['id'=>'name','placeholder'=>'Enter name','class'=>'form-control']) !!}
        <span class="text-danger">{{ $errors->first('name') }}</span>
    </div>
    <div class="col-lg-6 mb-3">
        <label for="address" class="form-label"> Address</label>
        {!! Form::text('address', $value = old('address'), ['id'=>'address','placeholder'=>'Enter address','class'=>'form-control']) !!}
        <span class="text-danger">{{ $errors->first('address') }}</span>
    </div>
    <div class="col-lg-6 mb-3">
        <label for="youtube_link" class="form-label"> Youtube Link</label>
        {!! Form::text('youtube_link', $value = old('youtube_link'), ['id'=>'youtube_link','placeholder'=>'Enter Youtube Link','class'=>'form-control']) !!}
        <span class="text-danger">{{ $errors->first('youtube_link') }}</span>
    </div>
    <div class="col-lg-6 mb-3">
        <label for="google_map_link" class="form-label"> Google Map Link</label>
        {!! Form::text('google_map_link', $value = old('google_map_link'), ['id'=>'google_map_link','placeholder'=>'Enter Google Map Link','class'=>'form-control']) !!}
        <span class="text-danger">{{ $errors->first('google_map_link') }}</span>
    </div>
    <div class="col-lg-6 mb-3">
        <label for="email" class="form-label"> Email</label>
        {!! Form::text('email', $value = old('email'), ['id'=>'email','placeholder'=>'Enter Email','class'=>'form-control']) !!}
        <span class="text-danger">{{ $errors->first('email') }}</span>
    </div>
    <div class="col-lg-6 mb-3">
        <label for="contact_no" class="form-label"> Contact No</label>
        {!! Form::text('contact_no', $value = old('contact_no'), ['id'=>'contact_no','placeholder'=>'Enter Contact No','class'=>'form-control']) !!}
        <span class="text-danger">{{ $errors->first('contact_no') }}</span>
    </div>
    <div class="col-lg-6 mb-3">
        <label for="contact_person" class="form-label"> Contact Person</label>
        {!! Form::text('contact_person', $value = old('contact_person'), ['id'=>'contact_person','placeholder'=>'Enter Contact Person','class'=>'form-control']) !!}
        <span class="text-danger">{{ $errors->first('contact_person') }}</span>
    </div>
    <div class="col-lg-12 mb-3">
        <label for="showroom_image" class="form-label">Upload Showroom Image</label>
        {!! Form::file('showroom_image',['id'=>'showroom_image','class'=>'form-control']) !!}
        @if($_showroom ?? false)
            <a href="{{ $_showroom->image_path  }}" target="_blank">
                <img src="{{ $_showroom->image_path  }}" alt="{{ $_showroom->name }}" height="100px" width="100px">
            </a>
        @endif
        <span class="text-danger">{{ $errors->first('showroom_image') }}</span>
    </div>
    <div class="text-center">
        <button type="submit" class="btn btn-primary"><i class="link-icon" data-feather="plus"></i> {{$btn}}</button>
    </div>
</div>
