$(document).ready(function () {
    $('#team_submit').validate({
        rules: {
            name: {required: true,},
            designation_id: {required: true,},
            description: {required: true,},
        },
        messages: {
            name: {
                required: "Please Enter a Team Name",
            },
            designation_id: {
                required: "Please Select Designation ",
            },
            description: {
                required: "Please Enter a Description",
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
