$(document).ready(function () {
    $('#showroom_submit').validate({
        rules: {
            name: {required: true,},
            address: {required: true,},
            google_map_link: {required: true,},
            email: {required: true,},
            contact_no: {required: true,},
            contact_person: {required: true,},
        },
        messages: {
            name: {
                required: "Please Enter a Name",
            },
            address: {
                required: "Please Enter a Address",
            },
            google_map_link: {
                required: "Please Enter a Google Map Link",
            },
            email: {
                required: "Please Enter a Email",
            },
            contact_no: {
                required: "Please Enter a Contact No",
            },
            contact_person: {
                required: "Please Enter a Contact Person",
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
