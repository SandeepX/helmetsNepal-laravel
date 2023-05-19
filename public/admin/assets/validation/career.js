$(document).ready(function () {
    $('#career_submit').validate({
        rules: {
            department_id: {required: true,},
            title: {required: true,},
            salary_details: {required: true,},
            description: {required: true,},
        },
        messages: {
            department_id: { required: "Select department name" },
            title: { required: "Please Enter Title" },
            salary_details: { required: "Please Enter Salary Details" },
            description: { required: "Please Enter Description" },
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
