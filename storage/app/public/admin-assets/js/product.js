$(".has_stock").on("change", function () {
    "use strict";
    check_stock_validation($(this).val());
});
$(".has_stock:checked").on("change", function () {
    "use strict";
    check_stock_validation($(this).val());
}).change();

function check_stock_validation(value) {
    "use strict";
    if (value == 1) {
        document.getElementById("block_stock_qty").style.display = "block";
        document.getElementById("block_min_order").style.display = "block";
        document.getElementById("block_max_order").style.display = "block";
        document.getElementById("block_product_low_qty_warning").style.display = "block";
        $("#qty").prop("required", true);
        $("#min_order").prop("required", true);
        $("#max_order").prop("required", true);
        $("#low_qty").prop("required", true);
    } else {
        document.getElementById("block_stock_qty").style.display = "none";
        document.getElementById("block_min_order").style.display = "none";
        document.getElementById("block_max_order").style.display = "none";
        document.getElementById("block_product_low_qty_warning").style.display = "none";
        $("#qty").prop("required", false);
        $("#min_order").prop("required", false);
        $("#max_order").prop("required", false);
        $("#low_qty").prop("required", false);
    }
}

function addimage(id) {

    "use strict";

    $("#product_id").val(id);

    $("#addModal").modal('show');

}

function imageview(id, image) {

    "use strict";

    $("#img_id").val(id);

    $("#img_name").val(image);

    $("#editModal").modal('show');

}

$(document).ready(function () {

    $('.sort_menu').sortable({
        handle: '.handle',
        cursor: 'move',
        placeholder: 'highlight',
        axis: "x,y",

        update: function (e, ui) {
            var sortData = $('.sort_menu').sortable('toArray', {
                attribute: 'data-id'
            })
            updateToDatabase(sortData.join('|'))
        }
    })

    function updateToDatabase(idString) {

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            dataType: "json",
            url: $('#carddetails').attr('data-url'),
            data: {
                ids: idString,
            },
            success: function (response) {
                if (response.status == 1) {
                    toastr.success(response.msg);
                } else {
                    toastr.success(wrong);
                }
            }
        });
    }

})