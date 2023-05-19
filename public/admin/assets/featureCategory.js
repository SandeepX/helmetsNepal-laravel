$(document).ready(function () {
    $('.live_search_product').select2({
        placeholder: 'Select Product',
        ajax: {
            url: '/cn-admin/product-search/search',
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.name,
                            id: item.id
                        }
                    })
                };
            },
            cache: true
        }
    });

    $(".live_search_product").change(function () {
        let product_id = $('#live_search_product').val();
        console.log(!smIsEmpty(product_id));

        /**
         * Dont do ajax execution if product_id not available.
         */
        if (!smIsEmpty(product_id)) {
            $.ajax({
                type: 'GET',
                url: '/cn-admin/product-search/'+product_id+'/product-search-detail',
                success: function (resp) {
                    console.log(resp);
                    $('#product-div').append(resp);
                }
            });
        }
    });
});
