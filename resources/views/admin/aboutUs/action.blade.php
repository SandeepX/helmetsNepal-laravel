<div class="row">
    <div class="col-lg-6 mb-3">
        <label for="about_us_title" class="form-label"> About us Title</label>
        {!! Form::text('about_us_title', $value = old('about_us_title'), ['id'=>'about_us_title','placeholder'=>'Enter About us Title','class'=>'form-control']) !!}
        <span class="text-danger">{{ $errors->first('about_us_title') }}</span>
    </div>
    <div class="col-lg-6 mb-3">
        <label for="about_us_sub_title" class="form-label"> About us Sub Title</label>
        {!! Form::text('about_us_sub_title', $value = old('about_us_sub_title'), ['id'=>'about_us_sub_title','placeholder'=>'Enter About us Sub Title','class'=>'form-control']) !!}
        <span class="text-danger">{{ $errors->first('about_us_sub_title') }}</span>
    </div>
    <div class="col-lg-12 mb-3">
        <label for="about_us_description" class="form-label"> About us Description</label>
        {!! Form::textarea('about_us_description', $value = old('about_us_description'), ['id'=>'about_us_description','placeholder'=>'Enter About us Description','class'=>'form-control']) !!}
        <span class="text-danger">{{ $errors->first('about_us_description') }}</span>
    </div>

    <hr>
    <div class="col-lg-6 mb-3">
        <label for="core_value_title" class="form-label"> Core Value Title</label>
        {!! Form::text('core_value_title', $value = old('core_value_title'), ['id'=>'core_value_title','placeholder'=>'Enter Core Value Title','class'=>'form-control']) !!}
        <span class="text-danger">{{ $errors->first('core_value_title') }}</span>
    </div>
    <div class="col-lg-6 mb-3">
        <label for="core_value_sub_title" class="form-label"> Core Value Sub Title</label>
        {!! Form::text('core_value_sub_title', $value = old('core_value_sub_title'), ['id'=>'core_value_sub_title','placeholder'=>'Enter Core Value Sub Title','class'=>'form-control']) !!}
        <span class="text-danger">{{ $errors->first('core_value_sub_title') }}</span>
    </div>
    <div class="col-lg-12 mb-3">
        <label for="core_value_description" class="form-label"> Core Value Description</label>
        {!! Form::textarea('core_value_description', $value = old('core_value_description'), ['id'=>'core_value_description','placeholder'=>'Enter Core Value Description','class'=>'form-control']) !!}
        <span class="text-danger">{{ $errors->first('core_value_description') }}</span>
    </div>
    <hr>
    <div class="col-lg-3 mb-3">
        <label for="who_we_are_title" class="form-label"> Who we are  Title</label>
        {!! Form::text('who_we_are_title', $value = old('who_we_are_title'), ['id'=>'who_we_are_title','placeholder'=>'Enter Who we are  Title','class'=>'form-control']) !!}
        <span class="text-danger">{{ $errors->first('who_we_are_title') }}</span>
    </div>
    <div class="col-lg-3 mb-3">
        <label for="who_we_are_sub_title" class="form-label"> Who we are Sub Title</label>
        {!! Form::text('who_we_are_sub_title', $value = old('who_we_are_sub_title'), ['id'=>'who_we_are_sub_title','placeholder'=>'Enter Who we are Sub Title','class'=>'form-control']) !!}
        <span class="text-danger">{{ $errors->first('who_we_are_sub_title') }}</span>
    </div>
    <div class="col-lg-3 mb-3">
        <label for="who_we_are_youtube" class="form-label"> Who we are YouTube link</label>
        {!! Form::text('who_we_are_youtube', $value = old('who_we_are_youtube'), ['id'=>'who_we_are_youtube','placeholder'=>'Enter Who we are YouTube link','class'=>'form-control']) !!}
        <span class="text-danger">{{ $errors->first('who_we_are_youtube') }}</span>
    </div>
    <div class="col-lg-3 mb-3">
        <label for="who_we_are_image" class="form-label"> Who we are Cover Image</label>
        {!! Form::file('who_we_are_image',['id'=>'who_we_are_image','class'=>'form-control']) !!}
        @if($_aboutUs ?? false)
            <a href="{{ $_aboutUs->who_we_are_image_path  }}" target="_blank">
                <img src="{{ $_aboutUs->who_we_are_image_path  }}" alt="{{ $_aboutUs->who_we_are_title }}" height="100px" width="100px">
            </a>
        @endif
        <span class="text-danger">{{ $errors->first('who_we_are_image') }}</span>
    </div>
    <div class="col-lg-12 mb-3">
        <label for="who_we_are_description" class="form-label"> Who we are Description</label>
        {!! Form::textarea('who_we_are_description', $value = old('who_we_are_description'), ['id'=>'who_we_are_description','placeholder'=>'Enter Who we are Description','class'=>'form-control']) !!}
        <span class="text-danger">{{ $errors->first('who_we_are_description') }}</span>
    </div>
    <hr>
    <div class="col-lg-4 mb-3">
        <label for="slogan_title" class="form-label"> Slogan Title</label>
        {!! Form::text('slogan_title', $value = old('slogan_title'), ['id'=>'slogan_title','placeholder'=>'Enter Slogan Title','class'=>'form-control']) !!}
        <span class="text-danger">{{ $errors->first('slogan_title') }}</span>
    </div>
    <div class="col-lg-4 mb-3">
        <label for="slogan_sub_title" class="form-label">Slogan Sub Title</label>
        {!! Form::text('slogan_sub_title', $value = old('slogan_sub_title'), ['id'=>'slogan_sub_title','placeholder'=>'Enter Slogan Sub Title','class'=>'form-control']) !!}
        <span class="text-danger">{{ $errors->first('slogan_sub_title') }}</span>
    </div>
    <div class="col-lg-4 mb-3">
        <label for="slogan_description" class="form-label"> Slogan Description</label>
        {!! Form::textarea('slogan_description', $value = old('slogan_description'), ['id'=>'slogan_description','placeholder'=>'Enter Slogan Description','class'=>'form-control']) !!}
        <span class="text-danger">{{ $errors->first('slogan_description') }}</span>
    </div>
    <div class="col-lg-4 mb-3">
        <label for="slogan_title_1" class="form-label"> Slogan Title 1</label>
        {!! Form::text('slogan_title_1', $value = old('slogan_title_1'), ['id'=>'slogan_title_1','placeholder'=>'Enter Slogan Title 1','class'=>'form-control']) !!}
        <span class="text-danger">{{ $errors->first('slogan_title_1') }}</span>
    </div>
    <div class="col-lg-4 mb-3">
        <label for="slogan_description_1" class="form-label"> Slogan Description 1</label>
        {!! Form::textarea('slogan_description_1', $value = old('slogan_description_1'), ['id'=>'slogan_description_1','placeholder'=>'Enter Slogan Description 1','class'=>'form-control']) !!}
        <span class="text-danger">{{ $errors->first('slogan_description_1') }}</span>
    </div>
    <div class="col-lg-4 mb-3">
        <label for="slogan_title_2" class="form-label"> Slogan Title 2</label>
        {!! Form::text('slogan_title_2', $value = old('slogan_title_2'), ['id'=>'slogan_title_2','placeholder'=>'Enter Slogan Title 2','class'=>'form-control']) !!}
        <span class="text-danger">{{ $errors->first('slogan_title_2') }}</span>
    </div>
    <div class="col-lg-4 mb-3">
        <label for="slogan_description_2" class="form-label"> Slogan Description 2</label>
        {!! Form::textarea('slogan_description_2', $value = old('slogan_description_2'), ['id'=>'slogan_description_2','placeholder'=>'Enter Slogan Description 2','class'=>'form-control']) !!}
        <span class="text-danger">{{ $errors->first('slogan_description_2') }}</span>
    </div>
    <hr>

    <div class="col-lg-6 mb-3">
        <label for="team_title" class="form-label"> Team Title</label>
        {!! Form::text('team_title', $value = old('team_title'), ['id'=>'team_title','placeholder'=>'Enter Team Title','class'=>'form-control']) !!}
        <span class="text-danger">{{ $errors->first('team_title') }}</span>
    </div>
    <div class="col-lg-6 mb-3">
        <label for="team_description" class="form-label"> Team Description</label>
        {!! Form::textarea('team_description', $value = old('team_description'), ['id'=>'team_description','placeholder'=>'Enter Team Description','class'=>'form-control']) !!}
        <span class="text-danger">{{ $errors->first('team_description') }}</span>
    </div>
    <hr>
    <div class="col-lg-4 mb-3">
        <label for="career_title" class="form-label"> Career Title</label>
        {!! Form::text('career_title', $value = old('career_title'), ['id'=>'career_title','placeholder'=>'Enter Career Title','class'=>'form-control']) !!}
        <span class="text-danger">{{ $errors->first('career_title') }}</span>
    </div>
    <div class="col-lg-4 mb-3">
        <label for="career_sub_title" class="form-label"> Career Sub Title</label>
        {!! Form::text('career_sub_title', $value = old('career_sub_title'), ['id'=>'career_sub_title','placeholder'=>'Enter Career Sub Title','class'=>'form-control']) !!}
        <span class="text-danger">{{ $errors->first('career_sub_title') }}</span>
    </div>
    <div class="col-lg-4 mb-3">
        <label for="career_image" class="form-label"> Career Cover Image</label>
        {!! Form::file('career_image',['id'=>'career_image','class'=>'form-control']) !!}
        @if($_aboutUs ?? false)
            <a href="{{ $_aboutUs->career_image_path }}" target="_blank">
                <img src="{{ $_aboutUs->career_image_path }}" alt="{{ $_aboutUs->career_title }}" height="100px" width="100px">
            </a>
        @endif
        <span class="text-danger">{{ $errors->first('career_image') }}</span>
    </div>
    <hr>
    <div class="col-lg-4 mb-3">
        <label for="testimonial_title" class="form-label"> Testimonial Title</label>
        {!! Form::text('testimonial_title', $value = old('testimonial_title'), ['id'=>'testimonial_title','placeholder'=>'Enter Testimonial Title','class'=>'form-control']) !!}
        <span class="text-danger">{{ $errors->first('testimonial_title') }}</span>
    </div>
    <div class="col-lg-4 mb-3">
        <label for="testimonial_sub_title" class="form-label"> Testimonial Sub Title</label>
        {!! Form::text('testimonial_sub_title', $value = old('testimonial_sub_title'), ['id'=>'testimonial_sub_title','placeholder'=>'Enter Testimonial Sub Title','class'=>'form-control']) !!}
        <span class="text-danger">{{ $errors->first('testimonial_sub_title') }}</span>
    </div>
    <div class="col-lg-4 mb-3">
        <label for="testimonial_description" class="form-label"> Testimonial Description</label>
        {!! Form::textarea('testimonial_description', $value = old('testimonial_description'), ['id'=>'testimonial_description','placeholder'=>'Enter Testimonial Description','class'=>'form-control']) !!}
        <span class="text-danger">{{ $errors->first('testimonial_description') }}</span>
    </div>
    <hr>


    <div class="col-lg-4 mb-3">
        <label for="rider_story_title" class="form-label"> Rider Story Title</label>
        {!! Form::text('rider_story_title', $value = old('rider_story_title'), ['id'=>'rider_story_title','placeholder'=>'Enter Rider Story Title','class'=>'form-control']) !!}
        <span class="text-danger">{{ $errors->first('rider_story_title') }}</span>
    </div>
    <div class="col-lg-4 mb-3">
        <label for="rider_story_sub_title" class="form-label"> Rider Story Sub Title</label>
        {!! Form::text('rider_story_sub_title', $value = old('rider_story_sub_title'), ['id'=>'rider_story_sub_title','placeholder'=>'Enter Rider Story Sub Title','class'=>'form-control']) !!}
        <span class="text-danger">{{ $errors->first('rider_story_sub_title') }}</span>
    </div>
    <div class="col-lg-4 mb-3">
        <label for="rider_story_description" class="form-label"> Rider Story Description</label>
        {!! Form::textarea('rider_story_description', $value = old('rider_story_description'), ['id'=>'rider_story_description','placeholder'=>'Enter Rider Story Description','class'=>'form-control']) !!}
        <span class="text-danger">{{ $errors->first('rider_story_description') }}</span>
    </div>
    <div class="col-lg-12 mb-3">
        <label for="rider_story_image" class="form-label"> Rider Story Cover Image</label>
        {!! Form::file('rider_story_image',['id'=>'rider_story_image','class'=>'form-control']) !!}
        @if($_aboutUs ?? false)
            <a href="{{ $_aboutUs->rider_story_image_path }}" target="_blank">
                <img src="{{ $_aboutUs->rider_story_image_path }}" alt="{{ $_aboutUs->rider_story_title }}" height="100px" width="100px">
            </a>
        @endif
        <span class="text-danger">{{ $errors->first('rider_story_image') }}</span>
    </div>
    <hr>

    <div class="col-lg-6 mb-3">
        <label for="showroom_title" class="form-label"> showroom Title</label>
        {!! Form::text('showroom_title', $value = old('showroom_title'), ['id'=>'showroom_title','placeholder'=>'Enter showroom Title','class'=>'form-control']) !!}
        <span class="text-danger">{{ $errors->first('showroom_title') }}</span>
    </div>
    <div class="col-lg-6 mb-3">
        <label for="showroom_description" class="form-label"> showroom Description</label>
        {!! Form::textarea('showroom_description', $value = old('showroom_description'), ['id'=>'showroom_description','placeholder'=>'Enter showroom Description','class'=>'form-control']) !!}
        <span class="text-danger">{{ $errors->first('showroom_description') }}</span>
    </div>
    <hr>
    <div class="col-lg-6 mb-3">
        <label for="brand_title" class="form-label"> Brand Title</label>
        {!! Form::text('brand_title', $value = old('brand_title'), ['id'=>'brand_title','placeholder'=>'Enter Brand Title','class'=>'form-control']) !!}
        <span class="text-danger">{{ $errors->first('brand_title') }}</span>
    </div>
    <div class="col-lg-6 mb-3">
        <label for="brand_description" class="form-label"> Brand Description</label>
        {!! Form::textarea('brand_description', $value = old('brand_description'), ['id'=>'brand_description','placeholder'=>'Enter Brand Description','class'=>'form-control']) !!}
        <span class="text-danger">{{ $errors->first('brand_description') }}</span>
    </div>
    <hr>
    <div class="col-lg-6 mb-3">
        <label for="newsletter_title" class="form-label"> Newsletter Title</label>
        {!! Form::text('newsletter_title', $value = old('newsletter_title'), ['id'=>'newsletter_title','placeholder'=>'Enter Newsletter Title','class'=>'form-control']) !!}
        <span class="text-danger">{{ $errors->first('newsletter_title') }}</span>
    </div>
    <div class="col-lg-6 mb-3">
        <label for="newsletter_description" class="form-label"> Newsletter Description</label>
        {!! Form::textarea('newsletter_description', $value = old('newsletter_description'), ['id'=>'newsletter_description','placeholder'=>'Enter Newsletter Description','class'=>'form-control']) !!}
        <span class="text-danger">{{ $errors->first('newsletter_description') }}</span>
    </div>
    <hr>
    <div class="col-lg-4 mb-3">
        <label for="blog_title" class="form-label"> Blog Title</label>
        {!! Form::text('blog_title', $value = old('blog_title'), ['id'=>'blog_title','placeholder'=>'Enter Blog Title','class'=>'form-control']) !!}
        <span class="text-danger">{{ $errors->first('blog_title') }}</span>
    </div>
    <div class="col-lg-4 mb-3">
        <label for="blog_sub_title" class="form-label"> Blog Sub Title</label>
        {!! Form::text('blog_sub_title', $value = old('blog_sub_title'), ['id'=>'blog_sub_title','placeholder'=>'Enter Blog Sub Title','class'=>'form-control']) !!}
        <span class="text-danger">{{ $errors->first('blog_sub_title') }}</span>
    </div>
    <div class="col-lg-4 mb-3">
        <label for="blog_description" class="form-label"> Blog Description</label>
        {!! Form::textarea('blog_description', $value = old('blog_description'), ['id'=>'blog_description','placeholder'=>'Enter Blog Description','class'=>'form-control']) !!}
        <span class="text-danger">{{ $errors->first('blog_description') }}</span>
    </div>
    <hr>
    <div class="col-lg-6 mb-3">
        <label for="blog_title" class="form-label"> Contact Us Title</label>
        {!! Form::text('contactUs_title', $value = old('contactUs_title'), ['id'=>'contactUs_title','placeholder'=>'Enter Contact Us Title','class'=>'form-control']) !!}
        <span class="text-danger">{{ $errors->first('contactUs_title') }}</span>
    </div>
    <div class="col-lg-6 mb-3">
        <label for="contactUs_description" class="form-label"> Contact Us Description</label>
        {!! Form::textarea('contactUs_description', $value = old('contactUs_description'), ['id'=>'contactUs_description','placeholder'=>'Enter Contact Us Description','class'=>'form-control']) !!}
        <span class="text-danger">{{ $errors->first('contactUs_description') }}</span>
    </div>
    <hr>
    <div class="col-lg-6 mb-3">
        <label for="contactUsGetInTouch_title" class="form-label"> Get In Touch Title</label>
        {!! Form::text('contactUsGetInTouch_title', $value = old('contactUsGetInTouch_title'), ['id'=>'contactUsGetInTouch_title','placeholder'=>'Enter Get In Touch Title','class'=>'form-control']) !!}
        <span class="text-danger">{{ $errors->first('contactUsGetInTouch_title') }}</span>
    </div>
    <div class="col-lg-6 mb-3">
        <label for="contactUsGetInTouch_description" class="form-label"> Get In Touch Description</label>
        {!! Form::textarea('contactUsGetInTouch_description', $value = old('contactUsGetInTouch_description'), ['id'=>'contactUsGetInTouch_description','placeholder'=>'Enter Get In Touch Description','class'=>'form-control']) !!}
        <span class="text-danger">{{ $errors->first('contactUsGetInTouch_description') }}</span>
    </div>
    <hr>
    <div class="col-lg-6 mb-3">
        <label for="flash_sale_title" class="form-label"> Flash Sale Title</label>
        {!! Form::text('flash_sale_title', $value = old('flash_sale_title'), ['id'=>'flash_sale_title','placeholder'=>'Enter Flash Sale  Title','class'=>'form-control']) !!}
        <span class="text-danger">{{ $errors->first('flash_sale_title') }}</span>
    </div>
    <div class="col-lg-6 mb-3">
        <label for="flash_sale_description" class="form-label"> Flash Sale Description</label>
        {!! Form::textarea('flash_sale_description', $value = old('flash_sale_description'), ['id'=>'flash_sale_description','placeholder'=>'Enter Flash Sale  Description','class'=>'form-control']) !!}
        <span class="text-danger">{{ $errors->first('flash_sale_description') }}</span>
    </div>
    <hr>
    <div class="text-center">
        <button type="submit" class="btn btn-primary"><i class="link-icon" data-feather="plus"></i> {{$btn}}</button>
    </div>
</div>
