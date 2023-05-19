$(document).ready(function () {
    $('#aboutUs_submit').validate({
        rules: {
            about_us_title: {required: true},
            about_us_sub_title: {required: true},
            about_us_description: {required: true},
            core_value_title: {required: true},
            core_value_sub_title: {required: true},
            core_value_description: {required: true},
            who_we_are_title: {required: true},
            who_we_are_sub_title: {required: true},
            who_we_are_description: {required: true},
            who_we_are_youtube: {required: true},
            slogan_title: {required: true},
            slogan_sub_title: {required: true},
            slogan_description: {required: true},
            slogan_title_1: {required: true},
            slogan_description_1: {required: true},
            slogan_title_2: {required: true},
            slogan_description_2: {required: true},
            team_title: {required: true},
            team_description: {required: true},
            career_title: {required: true},
            career_sub_title: {required: true},
            testimonial_title: {required: true},
            testimonial_sub_title: {required: true},
            testimonial_description: {required: true},
            rider_story_title: {required: true},
            rider_story_sub_title: {required: true},
            rider_story_description: {required: true},
            showroom_title: {required: true},
            showroom_description: {required: true},
            brand_title: {required: true},
            brand_description: {required: true},
            newsletter_title: {required: true},
            newsletter_description: {required: true},
            blog_title: {required: true},
            blog_sub_title: {required: true},
            blog_description: {required: true},
        },
        messages: {
            about_us_title: {required: "Please Enter About Us Title"},
            about_us_sub_title: {required: "Please Enter About Us sub Title"},
            about_us_description: {required: "Please Enter About Us Description"},
            core_value_title: {required: "Please Enter Core Value Title"},
            core_value_sub_title: {required: "Please Enter Core Value Sub Title"},
            core_value_description: {required: "Please Enter Core Value Description"},
            who_we_are_title: {required: "Please Enter Who we are Title"},
            who_we_are_sub_title: {required: "Please Enter Who we are Sub Title"},
            who_we_are_description: {required: "Please Enter Who we are Description"},
            who_we_are_youtube: {required: "Please Enter Who we are Youtube"},
            slogan_title: {required: "Please Enter Slogan Title"},
            slogan_sub_title: {required: "Please Enter Slogan Sub Title"},
            slogan_description: {required: "Please Enter Slogan Description"},
            slogan_title_1: {required: "Please Enter Slogan Title 1"},
            slogan_description_1: {required: "Please Enter Slogan Description 1"},
            slogan_title_2: {required: "Please Enter Slogan Title 2"},
            slogan_description_2: {required: "Please Enter Slogan Description 2"},
            team_title: {required: "Please Enter Team Title"},
            team_description: {required: "Please Enter Team Description"},
            career_title: {required: "Please Enter Career title"},
            career_sub_title: {required: "Please Enter Career Sub title"},
            testimonial_title: {required: "Please Enter Testimonial Title"},
            testimonial_sub_title: {required: "Please Enter Testimonial Sub Title"},
            testimonial_description: {required: "Please Enter Testimonial Description"},
            rider_story_title: {required: "Please Enter Rider Story Title"},
            rider_story_sub_title: {required: "Please Enter Rider Story Sub Title"},
            rider_story_description: {required: "Please Enter Rider Story Description"},
            showroom_title: {required: "Please Enter Showroom Title"},
            showroom_description: {required: "Please Enter Showroom Description"},
            brand_title: {required: "Please Enter Brand Title"},
            brand_description: {required: "Please Enter Brand Description"},
            newsletter_title: {required: "Please Enter Newsletter Title"},
            newsletter_description: {required: "Please Enter Newsletter Description"},
            blog_title: {required: "Please Enter Blog Title"},
            blog_sub_title: {required: "Please Enter Blog Sub Title"},
            blog_description: {required: "Please Enter Description"},
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('div').append(error);
        },
        highlight: function (element) {
            $(element).addClass('is-invalid');
            $(element).removeClass('is-valid');
            $(element).siblings().addClass("text-danger").removeClass("text-success");
            $(element).siblings().find('span .input-group-text').addClass("bg-danger ").removeClass("bg-success");
        },
        unhighlight: function (element) {
            $(element).removeClass('is-invalid');
            $(element).addClass('is-valid');
            $(element).siblings().addClass("text-success").removeClass("text-danger");
            $(element).find('span .input-group-prepend').addClass("bg-success").removeClass("bg-danger");
            $(element).siblings().find('span .input-group-text').addClass("bg-success").removeClass("bg-danger ");
        }
    });
});
