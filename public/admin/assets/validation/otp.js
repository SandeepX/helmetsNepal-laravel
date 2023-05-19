$(document).ready(function () {
    $('#otp_verify').validate({
        rules: {
            two_factor_code: {required: true,minlength:6,minLength:6},
        },
        messages: {
            two_factor_code: { required: "Please Enter 6 Digit OTP" },
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-otp');
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
