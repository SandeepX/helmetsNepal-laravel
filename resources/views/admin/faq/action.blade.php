<div class="row">
    <div class="col-lg-12 mb-3">
        <label for="faq_category_id" class="form-label"> Select Faq Category</label>
        {!! Form::select('faq_category_id',$_faqCategory, $value = old('faq_category_id'), ['id'=>'faq_category_id','class'=>'form-select','placeholder'=>'Select Faq Category']) !!}
        <span class="text-danger">{{ $errors->first('faq_category_id') }}</span>
    </div>
    <div class="col-lg-6 mb-3">
        <label for="question" class="form-label"> Question</label>
        {!! Form::textarea('question', $value = old('question'), ['id'=>'question','placeholder'=>'Enter Question','class'=>'form-control']) !!}
        <span class="text-danger">{{ $errors->first('question') }}</span>
    </div>
    <div class="col-lg-6 mb-3">
        <label for="answer" class="form-label"> Answer</label>
        {!! Form::textarea('answer', $value = old('answer'), ['id'=>'answer','placeholder'=>'Enter Answer','class'=>'form-control']) !!}
        <span class="text-danger">{{ $errors->first('answer') }}</span>
    </div>
    <div class="text-center">
        <button type="submit" class="btn btn-primary"><em class="link-icon" data-feather="plus"></em> {{$btn}}</button>
    </div>
</div>
