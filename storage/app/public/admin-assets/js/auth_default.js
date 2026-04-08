$(window).on("load", function () {
    "use strict";
    if ($(".multimenu").find(".active")) {
        $(".multimenu").find(".active").parent().parent().addClass("show");
        $(".multimenu").find(".active").parent().parent().parent().attr("aria-expanded", true);
    }
});
$('#name').on('blur', function () {
    "use strict";
    $('#slug').val($('#name').val().split(" ").join("-").toLowerCase());
});

function setLightMode() {
    document.body.classList.remove('dark');
    document.body.classList.add('light');
    localStorage.setItem('theme', 'light');
}

function setDarkMode() {
    document.body.classList.remove('light');
    document.body.classList.add('dark');
    localStorage.setItem('theme', 'dark');
}

// Load saved theme on page load
$(document).ready(function () {
    if (localStorage.getItem('theme') === 'dark') {
        setDarkMode();
    } else {
        setLightMode();
    }
});