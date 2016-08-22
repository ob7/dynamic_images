console.log("form assests loader");
var styleContainer = $('.style-preview-container');
$('#stylingOptions').change(function() {
    value = $(this).find('option:selected').val();
    resetClass();
    $(styleContainer).addClass(value);
});
function resetClass() {
    $(styleContainer).attr('class', 'style-preview-container');
}
