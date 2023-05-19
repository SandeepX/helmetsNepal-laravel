<div class="row">
    <div class="col-lg-12 mb-3">
        <label for="campaign_image" class="form-label">Coupon Banner Image</label>
        {!! Form::file('campaign_image',['id'=>'campaign_image','class'=>'form-control']) !!}
        @if($_coupon ?? false)
            <a href="{{ $_coupon->image_path  }}" target="_blank">
                <img src="{{ $_coupon->image_path  }}" alt="{{ $_coupon->campaign_name }}" height="100px" width="100px">
            </a>
        @endif
        <span class="text-danger">{{ $errors->first('campaign_image') }}</span>
    </div>
    <div class="col-lg-6 mb-3">
        <label for="campaign_name" class="form-label">Campaign Name</label>
        {!! Form::text('campaign_name', $value = old('campaign_name'), ['id'=>'campaign_name','placeholder'=>'Enter Campaign Name','class'=>'form-control']) !!}
        <span class="text-danger">{{ $errors->first('campaign_name') }}</span>
    </div>
    <div class="col-lg-6 mb-3">
        <label for="campaign_code" class="form-label"> Campaign Code</label>
        {!! Form::text('campaign_code', $value = old('campaign_code'), ['id'=>'campaign_code','placeholder'=>'Enter Campaign Code','class'=>'form-control']) !!}
        <span class="text-danger">{{ $errors->first('campaign_code') }}</span>
    </div>

    <div class="col-lg-6 mb-3">
        <label for="coupon_for" class="form-label">Coupon For <span style="color: red">*</span> </label>
        <select class="form-select" id="coupon_for" name="coupon_for" required>
            <option value="" {{isset($_coupon) && ($_coupon->coupon_for)  || old('coupon_for') !== null  ? '': 'selected'}}  disabled>Select </option>
            @foreach(\App\Models\Order\Coupon::COUPON_FOR as $value)
                <option value="{{$value}}" {{ isset($_coupon) && ($_coupon->coupon_for ) == $value || old('coupon_for') == $value  ? 'selected': old('coupon_for') }}>
                    {{ucfirst($value)}}</option>
            @endforeach
        </select>
        <span class="text-danger">{{ $errors->first('coupon_for') }}</span>
    </div>

    <div class="col-lg-6 mb-3 coupon_apply" >
        <label for="coupon_apply_on" class="form-label">Coupon Apply On <span style="color: red">*</span></label>
        <select class="form-select" id="couponAppliedOn" name="coupon_apply_on">

        </select>
        <span class="text-danger">{{ $errors->first('coupon_apply_on') }}</span>
    </div>

    <div class="col-lg-12 mb-3">
        <label class="form-label" for="coupon_type">Coupon Type</label>
        <div class="radio-put d-flex align-items-center align-middle pt-3">
            <div class="form-check form-check-inline">
                {!! Form::radio('coupon_type', 'flat', true,['class'=>'form-check-input' ,'id'=>'flat']) !!}
                <label class="form-check-label" for="flat">Flat Discount</label>
            </div>
            <div class="form-check form-check-inline">
                {!! Form::radio('coupon_type', 'percentage', false,['class'=>'form-check-input' ,'id'=>'percentage']) !!}
                <label class="form-check-label" for="percentage">Percentage</label>
            </div>
        </div>
    </div>

    <div class="col-lg-12 mb-3">
        <label for="coupon_value" class="form-label"> Coupon Discount Amount</label>
        {!! Form::number('coupon_value', $value = old('coupon_value'), ['id'=>'coupon_value','placeholder'=>'Enter Coupon Discount Amount','class'=>'form-control']) !!}
        <span class="text-danger">{{ $errors->first('coupon_value') }}</span>
    </div>
    <div class="col-lg-6 mb-3">
        <label for="starting_date" class="form-label">Coupon Starting Date</label>
        <div class="input-group date datepicker" id="starting_date_input">
            {!! Form::text('starting_date', $value = old('starting_date'), ['id'=>'starting_date','class'=>'form-control']) !!}
            <span class="input-group-text input-group-addon"><i data-feather="calendar"></i></span>
        </div>
        <span class="text-danger">{{ $errors->first('starting_date') }}</span>
    </div>
    <div class="col-lg-6 mb-3">
        <label for="expiry_date" class="form-label">Coupon End Date</label>
        <div class="input-group date datepicker" id="expiry_date_input">
            {!! Form::text('expiry_date', $value = old('expiry_date'), ['id'=>'expiry_date','class'=>'form-control']) !!}
            <span class="input-group-text input-group-addon"><i data-feather="calendar"></i></span>
        </div>
        <span class="text-danger">{{ $errors->first('expiry_date') }}</span>
    </div>

    <div class="col-lg-6 mb-3">
        <label for="min_amount" class="form-label"> Minimum Amount</label>
        {!! Form::number('min_amount', $value = old('min_amount'), ['id'=>'min_amount','placeholder'=>'Enter Minimum Amount','class'=>'form-control']) !!}
        <span class="text-danger">{{ $errors->first('min_amount') }}</span>
    </div>
    <div class="col-lg-6 mb-3">
        <label for="max_amount" class="form-label"> Maximum Amount</label>
        {!! Form::number('max_amount', $value = old('max_amount'), ['id'=>'max_amount','placeholder'=>'Enter Maximum Amount','class'=>'form-control']) !!}
        <span class="text-danger">{{ $errors->first('max_amount') }}</span>
    </div>
    <div class="text-center">
        <button type="submit" class="btn btn-primary"><i class="link-icon" data-feather="plus"></i>
            Add Coupon
        </button>
    </div>
</div>
