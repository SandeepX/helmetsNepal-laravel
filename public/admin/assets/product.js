$(document).ready(function () {
    $('.numeric').keyup(function () {
        if (this.value.match(/[^0-9.]/g)) {
            this.value = this.value.replace(/[^0-9.]/g, '');
        }
    });
    $('#main_category_id').on('change', function () {
        const main_category_id = $('#main_category_id').val();
        $.ajax({
            type: 'GET',
            url: "/cn-admin/category/" + main_category_id + "/get-child",
            success: function (resp) {
                if (resp != false) {
                    $('.parent_category_id_div').show();
                    $('.category_id_div').hide();
                    $('.parent_category').empty();
                    $('.category').empty();
                    $('.parent_category').html(resp);
                } else {
                    $('.parent_category_id_div').hide();
                    $('.category_id_div').hide();
                    $('.parent_category').empty();
                    $('.category').empty();
                }
            }
        });
    });

    $('#parent_category_id').on('change', function () {
        const parent_category_id = $('#parent_category_id').val();
        $.ajax({
            type: 'GET',
            url: "/cn-admin/category/" + parent_category_id + "/get-child",
            success: function (resp) {
                if (resp != false) {
                    $('.category_id_div').show();
                    $('.category').empty();
                    $('.category').html(resp);
                } else {
                    $('.category_id_div').hide();
                    $('.category').empty();
                }
            }
        });
    });




    $('.remove-image').on('click', function (event) {

        event.preventDefault();

        Swal.fire({
            title: 'Are you sure you want to Delete Product Image ?',
            showDenyButton: true,
            confirmButtonText: `Yes`,
            denyButtonText: `No`,
            padding: '10px 50px 10px 50px',
            allowOutsideClick: false
        }).then((result) => {
            if (result.isConfirmed) {
                let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                let productImage_id = $(this).attr('productImage_id');
                let image_div_id = $(this).attr('image_div_id');
                $.ajax({
                    type: 'POST',
                    url: "/cn-admin/product/" + productImage_id + "/delete-product-image",
                    data: {_token: CSRF_TOKEN},
                    success: function (results) {
                        if (results.success === true) {
                            $('#' + image_div_id).remove();
                            Swal.fire("Done!", results.message, "success");
                        } else {
                            Swal.fire("Error!", results.message, "error");
                        }
                    }
                });
            }
        });
    });

    $('.tags-form-control').tagsInput({
        'width': '100%',
        'height': '75%',
        'interactive': true,
        'defaultText': 'Add More',
        'removeWithBackspace': true,
        'minChars': 0,
        'maxChars': 20,
        'placeholderColor': '#666666'
    });

    $('.remove-product-attribute-image').on('click', function (event) {

        event.preventDefault();

        Swal.fire({
            title: 'Are you sure you want to Delete Product Image ?',
            showDenyButton: true,
            confirmButtonText: `Yes`,
            denyButtonText: `No`,
            padding: '10px 50px 10px 50px',
            allowOutsideClick: false
        }).then((result) => {
            if (result.isConfirmed) {
                let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                let productAttributeImage_id = $(this).attr('productAttributeImage_id');
                let image_div_id = $(this).attr('image_div_id');
                let section = $(this).attr('section');
                let productAttributeDetail_id = $(this).attr('productAttributeDetail_id');
                $.ajax({
                    type: 'POST',
                    url: "/cn-admin/product/" + productAttributeDetail_id + "/delete-product-attribute-image",
                    data: {
                        _token: CSRF_TOKEN,
                        productAttributeImage_id: productAttributeImage_id,
                        section: section,
                    },
                    success: function (results) {
                        if (results.success === true) {
                            $('#' + image_div_id).remove();
                            Swal.fire("Done!", results.message, "success");
                        } else {
                            Swal.fire("Error!", results.message, "error");
                        }
                    }
                });
            }
        });
    });

    $("#image-uploadify").imageuploadify();


    $('input[type=radio][name=color_status]').change(function () {
        let color_status = parseInt($(this).val());
        if (color_status === 1) {
            console.log('color_status');
            $('#color-div').show();
        } else {
            console.log('color_statusss');
            $('#color-div').hide();
        }
    });
    $('input[type=radio][name=size_status]').change(function () {
        let size_status = parseInt($(this).val());

        if (size_status === 1) {
            $('#size-div').show();
        } else {
            $('#size-div').hide();
        }
    });

    $('input[type=radio][name=custom_status]').change(function () {
        let custom_status = parseInt($(this).val());
        if (custom_status === 1) {
            $('.custom-div').show();
        } else {
            $('.custom-div').hide();
        }
    });


    $('.add-div').on('click', function () {
        let index_value = parseInt($('#index_value').val());
        $.ajax({
            type: 'GET',
            url: "/cn-admin/product-color-row",
            data: {
                index_value: index_value,
            },
            success: function (results) {
                $('#div-color').append(results);
                $('#index_value').val(index_value + 1);
            }
        });
    });


});
$(document).on('click', '.delete-div', function () {
    $(this).parent().parent().remove();
});
$(document).on('change', '.color_gradient', function () {
    let color_gradient = parseInt($(this).val());
    if (color_gradient === 1) {
        $(this).parent().parent().parent().siblings('.color_gradient_div').show();
    } else {
        $(this).parent().parent().parent().siblings('.color_gradient_div').hide();
        $(this).parent().parent().parent().siblings('.color_gradient_div').children('.form-select').val('').change();
    }
});
function readFile(input) {
    $("#status").html('Processing...');
    counter = input.files.length;
    for (x = 0; x < counter; x++) {
        if (input.files && input.files[x]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $("#photos").append('<div class="col-md-3 image-item position-relative"><img src="' + e.target.result + '" class="img-thumbnail w-100 rounded">  <a href="#" class="remove-image" ><i class="link-icon" data-feather="x"></i></a></div>');
            };
            console.log(input.files[x]);
            reader.readAsDataURL(input.files[x]);
        }
    }
    if (counter == x) {
        $("#status").html('');
    }
}
