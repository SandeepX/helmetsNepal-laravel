
$(document).ready(function () {
    $('.product-tag').on('click', function () {
        const product_id = $(this).attr('product-id');
        console.log(product_id);
        $.ajax({
            type: 'GET',
            url: "/cn-admin/" + product_id + "/product-tag",
            success: function (resp) {
                $('.product-tag-model').html('');
                $('.product-tag-model').html(resp);
            }
        });
    });
    $('.status_model').on('click', function () {
        var link = $(this).attr('link');
        $('.get_link').attr('action', link);
    });


    $('.change-approve-status-toggle').on('click', function (event) {

        event.preventDefault();

        Swal.fire({
            title: 'Are you sure you want to change Approve status ?',
            showDenyButton: true,
            confirmButtonText: `Yes`,
            denyButtonText: `No`,
            padding: '10px 50px 10px 50px',
            allowOutsideClick: false
        }).then((result) => {
            if (result.isConfirmed) {
                let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                let url = $(this).attr('href');
                $.ajax({
                    type: 'GET',
                    url: url,
                    data: {
                        _token: CSRF_TOKEN,
                    },
                    success: function (results) {
                        if (results.success === true) {
                            Swal.fire("Done!", results.message, "success");
                            location.reload();
                        } else {
                            Swal.fire("Error!", results.message, "error");
                        }
                    }
                });
            }
        });
    });


});
