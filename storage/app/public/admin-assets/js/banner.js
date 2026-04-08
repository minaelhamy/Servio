    $(".type").on('change', function () {
        "use strict";
        $(this).find("option:selected").each(function () {
            var optionValue = $(this).attr("value");
            if (optionValue) {
                $(".selecttype").not("." + optionValue).addClass('dn');
                $(".selecttype").not("." + optionValue).find('select').prop('required', false);
                $("." + optionValue).removeClass('dn');
                $("." + optionValue).find('select').prop('required', true);
            } else {
                $(".selecttype").addClass('dn');
                $(".selecttype").find('select').prop('required', false);
            }
        });
    }).change();
