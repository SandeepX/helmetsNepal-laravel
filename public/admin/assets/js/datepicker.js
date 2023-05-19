$(function () {
    'use strict';

    if ($('#datePickerExample').length) {
        var date = new Date();
        var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
        $('#datePickerExample').datepicker({
            format: "mm/dd/yyyy",
            todayHighlight: true,
            autoclose: true
        });
        $('#datePickerExample').datepicker('setDate', today);
    }

    if ($('#starting_date_input').length) {
        var date = new Date();
        var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
        $('#starting_date_input').datepicker({
            format: "yyyy/mm/dd",
            todayHighlight: true,
            autoclose: true
        });
        let starting_date_input = $('#starting_date').val();
        let today_setDate = (starting_date_input == "" ? today : starting_date_input)
        $('#starting_date_input').datepicker('setDate', today_setDate);
    }
    if ($('#expiry_date_input').length) {
        var date = new Date();
        var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
        $('#expiry_date_input').datepicker({
            format: "yyyy/mm/dd",
            todayHighlight: true,
            autoclose: true
        });
        let expiry_date_input = $('#expiry_date').val();
        let today_setDate = (expiry_date_input == "" ? today : expiry_date_input)
        $('#expiry_date_input').datepicker('setDate', today_setDate);
    }


    if ($('#blog_publish_date_input').length) {
        var date = new Date();
        var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
        $('#blog_publish_date_input').datepicker({
            format: "yyyy/mm/dd",
            todayHighlight: true,
            autoclose: true
        });
        let blog_publish_date_input = $('#blog_publish_date').val();
        let today_setDate = (blog_publish_date_input == "" ? today : blog_publish_date_input)
        $('#blog_publish_date_input').datepicker('setDate', today_setDate);
    }


});
