$(window).on('scroll', function() {
    "use strict";
    if ($(window).scrollTop() > 300) {
        $('#back-to-top').addClass('show');
    } else {
        $('#back-to-top').removeClass('show');
    }
});
$('#back-to-top').on('click', function(e) {
    "use strict";
    e.preventDefault();
    $('html, body').animate({
        scrollTop: 0
    }, '300');
});