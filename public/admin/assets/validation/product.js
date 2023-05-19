$(document).ready(function () {
    $('#product_submit').validate({
        rules: {
            title: {required: true,},
            product_code: {required: true,},
            main_category_id: {required: true,},
            product_price: {required: true,},
            details: {required: true,},
            quantity: {required: true,},
        },
        messages: {
            name: { required: "Please Enter Product Name" },
            product_code: { required: "Please Enter Product Code" },
            main_category_id: { required: "Select Category" },
            product_price: { required: "Please Enter Product price" },
            details: { required: "Please Enter Details" },
            quantity: { required: "Please Enter Product Quantity" },
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
