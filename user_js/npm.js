/*Modern view*/
;$(document).ready(function($) {
    var h_height = 0;
    $('#Modern .item').each(function () {
        if ($(this).height() > h_height) {
            h_height = $(this).height();
        }
    });
    $('#Modern .item').height(h_height);
});