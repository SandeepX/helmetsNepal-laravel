$(document).ready(function () {
    $('#riderStory_submit').validate({
        rules: {
            name: {required: true,},
            designation: {required: true,},
            quote: {required: true,},
            description: {required: true,},
        },
        messages: {
            name: {
                required: "Please Enter a name",
            },
            designation: {
                required: "Please Enter a Designation",
            },
            quote: {
                required: "Please Enter a Quote ",
            },
            description: {
                required: "Please Enter a Details Description",
            },
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
