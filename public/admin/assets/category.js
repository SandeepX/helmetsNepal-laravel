$(document).ready(function () {
    $('.parent_category').on('change', function () {
        const parent_category = $('.parent_category').val();
        $.ajax({
            type: 'GET',
            url: "/cn-admin/category/"+parent_category +"/get-child",
            success: function (resp) {
                if(resp != false){
                    $('.child-category-div').show();
                    $('.child_category').empty();
                    $('.child_category').html(resp);
                }else{
                    $('.child-category-div').hide();
                    $('.child_category').empty();
                }
            }
        });
    });
});
