<div class="row">
    <div class="col-lg-12 mb-3">
        <label for="title" class="form-label"> Name</label>
        {!! Form::text('name', $value = old('name'), ['id'=>'name','placeholder'=>'Enter Name','class'=>'form-control']) !!}
        <span class="text-danger">{{ $errors->first('name') }}</span>
    </div>
    @if($_category['category'] ?? '')
        <div class="col-lg-12 mb-3">
            <label for="parent_id" class="form-label"> Select Parent Category</label>
            {!! Form::select('parent_id',$_categorySelectList, $value = $_category['parent_category_id'], ['id'=>'parent_id','class'=>'form-select parent_category','placeholder'=>'Select Parent Category']) !!}
            <span class="text-danger">{{ $errors->first('parent_id') }}</span>
        </div>
    @else
        <div class="col-lg-12 mb-3">
            <label for="parent_id" class="form-label"> Select Parent Category</label>
            {!! Form::select('parent_id',$_categorySelectList, $value = old('parent_id'), ['id'=>'parent_id','class'=>'form-select parent_category','placeholder'=>'Select Parent Category']) !!}
            <span class="text-danger">{{ $errors->first('parent_id') }}</span>
        </div>
    @endif
    <div class="col-lg-12 mb-3">
        <label for="category_image" class="form-label">Upload Category Image</label>
        {!! Form::file('category_image',['id'=>'category_image','class'=>'form-control']) !!}
        @if($_category['category'] ?? false)
            <a href="{{ $_category['category']->image_path  }}" target="_blank">
                <img src="{{ $_category['category']->image_path  }}" alt="{{ $_category['category']->name }}" height="100px" width="100px">
            </a>

        @endif
        <span class="text-danger">{{ $errors->first('category_image') }}</span>
    </div>
    <div class="text-center">
        <button type="submit" class="btn btn-primary"><i class="link-icon" data-feather="plus"></i> {{$btn}}</button>
    </div>
</div>
