<div class="row">
    <div class="col-lg-12 mb-3">
        <label for="title" class="form-label"> Delivery Charge</label>
    </div>
    <div class="col-lg-12 mb-3">
        <label for="delivery_charge_amount" class="form-label"> Delivery Charge Amount </label>
        {!! Form::text('delivery_charge_amount', $value = old('delivery_charge_amount'), ['id'=>'delivery_charge_amount','placeholder'=>'Enter Delivery Charge Amount','class'=>'form-control']) !!}
        <span class="text-danger">{{ $errors->first('delivery_charge_amount') }}</span>
    </div>
    <div class="text-center">
        <button type="submit" class="btn btn-primary"><i class="link-icon" data-feather="plus"></i> {{$btn}}</button>
    </div>
</div>
