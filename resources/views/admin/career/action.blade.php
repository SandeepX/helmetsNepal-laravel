<div class="row">
    <div class="col-lg-12 mb-3">
        <label for="department_id" class="form-label"> Select Department</label>
        {!! Form::select('department_id',$_department, $value = old('department_id'), ['id'=>'department_id','class'=>'form-select','placeholder'=>'Select Department']) !!}
        <span class="text-danger">{{ $errors->first('department_id') }}</span>
    </div>
    <div class="col-lg-12 mb-3">
        <label for="title" class="form-label">Title / Position</label>
        {!! Form::text('title', $value = old('title'), ['id'=>'title','placeholder'=>'Enter Title / Position','class'=>'form-control']) !!}
        <span class="text-danger">{{ $errors->first('title') }}</span>
    </div>
    <div class="col-lg-12 mb-3">
        <label for="salary_details" class="form-label">Salary Details</label>
        {!! Form::text('salary_details', $value = old('salary_details'), ['id'=>'salary_details','placeholder'=>'Enter Salary Details','class'=>'form-control']) !!}
        <span class="text-danger">{{ $errors->first('salary_details') }}</span>
    </div>
    <div class="col-lg-12 mb-3">
        <label for="description" class="form-label"> Description</label>
        {!! Form::textarea('description', $value = old('description'), ['id'=>'summernote','placeholder'=>'Enter Description','class'=>'form-control']) !!}
        <span class="text-danger">{{ $errors->first('description') }}</span>
    </div>
    <div class="text-center">
        <button type="submit" class="btn btn-primary"><em class="link-icon" data-feather="plus"></em> {{$btn}}</button>
    </div>
</div>
