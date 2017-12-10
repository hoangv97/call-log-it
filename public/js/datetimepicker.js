function initDatetimepicker(selector) {
    $(selector).datetimepicker({
        autoclose: true,
        todayHighlight: true,
        fontAwesome: true,
        pickerPosition: 'bottom-left',
        container: '#deadline-picker',
        format: 'yyyy-mm-dd hh:ii:00'
    });
}