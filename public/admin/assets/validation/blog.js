$(document).ready(function () {
    $('#blog_submit').validate({
        rules: {
            blog_category_id: {required: true,},
            title: {required: true,},
            blog_created_by: {required: true,},
            blog_read_time: {required: true,},
            blog_publish_date: {required: true,},
            description: {required: true,},
        },
        messages: {
            blog_category_id: { required: "Select Blog Category" },
            title: { required: "Please Enter a Title " },
            blog_created_by: { required: "Please Enter a Blog creator" },
            blog_read_time: { required: "Please Enter a Blog Read Time" },
            blog_publish_date: { required: "Please Enter a Blog Publish date" },
            description: { required: "Please Enter a Description" }
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
