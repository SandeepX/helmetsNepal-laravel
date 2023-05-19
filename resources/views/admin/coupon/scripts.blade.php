<script>
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        let couponFor = $('#coupon_for').val();
        (couponFor == null) ? $('.coupon_apply').hide() :  $('.coupon_apply').show();

        $('#coupon_for').on('change',function(){
            let couponFor =  $(this).val();
            if(couponFor != null && couponFor == 'all'){
                $('#couponAppliedOn').val('');
                $('.coupon_apply').hide();
                $('#couponAppliedOn').removeAttr('required');
            }else{
                $('.coupon_apply').show();
                $('#couponAppliedOn').prop('required', 'true');
            }
        });

        $('#coupon_for').change(function() {
            let selectedCouponFor = $('#coupon_for option:selected').val();
            let couponAppliedId = "{{ isset($_coupon) ? $_coupon->coupon_apply_on : '' }}";
            $('#couponAppliedOn').empty();
            if (selectedCouponFor) {
                $.ajax({
                    type: 'GET',
                    url: "{{ url('cn-admin/coupon/apply-on') }}" + '/' + selectedCouponFor ,
                }).done(function(response) {
                    if(!couponAppliedId){
                        $('#couponAppliedOn').append('<option value=""  selected >--Select--</option>');
                    }
                    if(selectedCouponFor == 'category'){
                        response.data.forEach(function(data) {
                            $('#couponAppliedOn').append('<option ' + ((data.id == couponAppliedId) ? "selected" : '') + ' value="'+data.id+'" >'+capitalize(data.name)+'</option>');
                        });
                    }else{
                        response.data.forEach(function(data) {
                            $('#couponAppliedOn').append('<option ' + ((data.id == couponAppliedId) ? "selected" : '') + ' value="'+data.id+'" >'+capitalize(data.title)+'</option>');
                        });
                    }
                });
            }
        }).trigger('change');
    });




    function capitalize(str) {
        strVal = '';
        str = str.split(' ');
        for (var chr = 0; chr < str.length; chr++) {
            strVal += str[chr].substring(0, 1).toUpperCase() + str[chr].substring(1, str[chr].length) + ' '
        }
        return strVal
    }
</script>
