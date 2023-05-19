<div class="row">
    <div class="col-lg-12 mb-3">
        <label for="team_image" class="form-label">Upload Image</label>
        {!! Form::file('team_image',['id'=>'team_image','class'=>'form-control']) !!}
        @if($_team ?? false)
            <a href="{{ $_team->image_path  }}" target="_blank">
                <img src="{{ $_team->image_path  }}" alt="{{ $_team->title }}" height="100px" width="100px">
            </a>
        @endif
        <span class="text-danger">{{ $errors->first('team_image') }}</span>
    </div>
    <div class="col-lg-6 mb-3">
        <label for="name" class="form-label"> Team Name</label>
        {!! Form::text('name', $value = old('name'), ['id'=>'name','placeholder'=>'Enter Title','class'=>'form-control']) !!}
        <span class="text-danger">{{ $errors->first('name') }}</span>
    </div>
    <div class="col-lg-12 mb-3">
        <label for="designation_id" class="form-label"> Select Designation</label>
        {!! Form::select('designation_id',$_designation, $value = old('designation_id'), ['id'=>'designation_id','class'=>'form-select','placeholder'=>'Select Designation']) !!}
        <span class="text-danger">{{ $errors->first('designation_id') }}</span>
    </div>
    <div class="col-lg-6 mb-3">
        <label for="description" class="form-label"> Description</label>
        {!! Form::textarea('description', $value = old('description'), ['id'=>'description','placeholder'=>'Enter Description','class'=>'form-control']) !!}
        <span class="text-danger">{{ $errors->first('description') }}</span>
    </div>
    <div class="text-center">
        <button type="submit" class="btn btn-primary"><i class="link-icon" data-feather="plus"></i> {{$btn}}</button>
    </div>
</div>
