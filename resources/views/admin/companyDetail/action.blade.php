<div class="row">
    <div class="col-lg-6 mb-3">
        <label for="logo" class="form-label"> Company Logo</label>
        {!! Form::file('logo',['id'=>'logo','class'=>'form-control']) !!}
        @if($_companyDetail ?? false)
            <a href="{{ $_companyDetail->logo_image_path  }}" target="_blank">
                <img src="{{ $_companyDetail->logo_image_path  }}" alt="Image" height="100px" width="100px">
            </a>
        @endif
        <span class="text-danger">{{ $errors->first('logo') }}</span>
    </div>
    <div class="col-lg-6 mb-3">
        <label for="address" class="form-label"> Address</label>
        {!! Form::text('address', $value = old('address'), ['id'=>'address','placeholder'=>'Enter Address','class'=>'form-control']) !!}
        <span class="text-danger">{{ $errors->first('address') }}</span>
    </div>
    <div class="col-lg-6 mb-3">
        <label for="email" class="form-label">Email </label>
        {!! Form::text('email', $value = old('email'), ['id'=>'email','placeholder'=>'Enter Email','class'=>'form-control']) !!}
        <span class="text-danger">{{ $errors->first('email') }}</span>
    </div>
    <div class="col-lg-6 mb-3">
        <label for="contact_no" class="form-label">Contact No </label>
        {!! Form::text('contact_no', $value = old('contact_no'), ['id'=>'contact_no','placeholder'=>'Enter Contact No','class'=>'form-control']) !!}
        <span class="text-danger">{{ $errors->first('contact_no') }}</span>
    </div>
    <div class="col-lg-6 mb-3">
        <label for="contact_person" class="form-label">Contact Person </label>
        {!! Form::text('contact_person', $value = old('contact_person'), ['id'=>'contact_person','placeholder'=>'Enter Contact Person','class'=>'form-control']) !!}
        <span class="text-danger">{{ $errors->first('contact_person') }}</span>
    </div>
    <div class="col-lg-6 mb-3">
        <label for="google_map_link" class="form-label"> Google Map Link</label>
        {!! Form::text('google_map_link', $value = old('google_map_link'), ['id'=>'google_map_link','placeholder'=>'Enter Google Map Link','class'=>'form-control']) !!}
        <span class="text-danger">{{ $errors->first('google_map_link') }}</span>
    </div>
    <div class="col-lg-6 mb-3">
        <label for="facebook_link" class="form-label"> Facebook Link</label>
        {!! Form::text('facebook_link', $value = old('facebook_link'), ['id'=>'facebook_link','placeholder'=>'Enter facebook_link','class'=>'form-control']) !!}
        <span class="text-danger">{{ $errors->first('facebook_link') }}</span>
    </div>
    <div class="col-lg-6 mb-3">
        <label for="instagram_link" class="form-label"> Instagram Link</label>
        {!! Form::text('instagram_link', $value = old('instagram_link'), ['id'=>'instagram_link','placeholder'=>'Enter Instagram Link','class'=>'form-control']) !!}
        <span class="text-danger">{{ $errors->first('instagram_link') }}</span>
    </div>
    <div class="col-lg-6 mb-3">
        <label for="twitter_link" class="form-label"> Twitter Link</label>
        {!! Form::text('twitter_link', $value = old('twitter_link'), ['id'=>'twitter_link','placeholder'=>'Enter Twitter Link','class'=>'form-control']) !!}
        <span class="text-danger">{{ $errors->first('twitter_link') }}</span>
    </div>
    <div class="col-lg-6 mb-3">
        <label for="youtube_link" class="form-label"> Youtube Link</label>
        {!! Form::text('youtube_link', $value = old('youtube_link'), ['id'=>'youtube_link','placeholder'=>'Enter Youtube Link','class'=>'form-control']) !!}
        <span class="text-danger">{{ $errors->first('youtube_link') }}</span>
    </div>
    <div class="col-lg-6 mb-3">
        <label for="frontend_link" class="form-label"> Frontend Link</label>
        {!! Form::text('frontend_link', $value = old('frontend_link'), ['id'=>'frontend_link','placeholder'=>'Enter Youtube Link','class'=>'form-control']) !!}
        <span class="text-danger">{{ $errors->first('frontend_link') }}</span>
    </div>

    <div class="text-center">
        <button type="submit" class="btn btn-primary"><i class="link-icon" data-feather="plus"></i> {{$btn}}</button>
    </div>
</div>
