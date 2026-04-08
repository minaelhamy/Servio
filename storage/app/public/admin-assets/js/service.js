function addimage(id) {

    "use strict";

    $("#service_id").val(id);

    $("#addModal").modal('show');

}

function imageview(id, image) {

    "use strict";

    $("#img_id").val(id);

    $("#img_name").val(image);

    $("#editModal").modal('show');

}



$('#staff-switch').change(function () {

    if ($(this).is(':checked')) {

        $('#staff').prop('required', true);

    } else {

        $('#staff').prop('required', false);

    }

}).change();


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

//Global Extras
$("#additional_no").on("change", function () {
    "use strict";
    if ($("#additional_no").prop("checked") == true) {
        $("#extras").addClass("d-none");
        $('#add_additional_service').addClass('d-none');
        $("#add_extras").addClass("d-none");
        $("#globalextra").addClass("d-none");
        $('#extras input:text').prop('required', false);
    }
}).change();
$("#additional_yes").on("change", function () {
    "use strict";
    if ($("#additional_yes").prop("checked") == true) {
        $("#extras").removeClass("d-none");
        $('#add_additional_service').removeClass('d-none');
        $("#add_extras").removeClass("d-none");
        $("#globalextra").removeClass("d-none");
        $('#extras input:text').prop('required', true);
    }
}).change();

var add_service_row = 1;
function additional_service_fields(name, price) {
    "use strict";
    add_service_row++;
    var divtest = document.createElement("div");
    divtest.setAttribute("class", "form-group mb-0 removeextras" + add_service_row);
    divtest.innerHTML = '<div class="col-12 m-0 variations"><div class="row"><div class="col-md-4"><div class="form-group"><input type="text" class="form-control" name="additional_service_name[]" placeholder="' +
        name + '" required></div></div><div class="col-md-4"><div class="form-group"><input type="number" step="any" class="form-control numbers_only" name="additional_service_price[]"  placeholder="' +
        price + '" required></div></div><div class="col-md-4"><div class="form-group"><div class="d-flex gap-2"><input type="file" step="any" class="form-control" name="additional_service_image[]" required><button class="btn btn-danger" type="button" onclick="remove_additional_service_fields(' + add_service_row + ');"><i class="fa-solid fa-trash"></i></button></div></div></div></div>';
    $("#more_additional_service_fields").append(divtest);
}
function remove_additional_service_fields(rid) {
    "use strict";
    $(".removeextras" + rid).remove();
}

function more_editadditional_service_fields(name, price) {
    "use strict";
    if (!$("span").hasClass("hiddenextrascount")) {
        $("#more_editadditional_service_fields").prepend(
            '<span class="hiddenextrascount d-none">' + 1 + "</span>"
        );
    }
    var editservice = $("span.hiddenextrascount:last()").html();
    editservice++;
    var editdivtest = document.createElement("div");
    editdivtest.setAttribute("class", "col-12 m-0 editextrasclass" + editservice);
    editdivtest.innerHTML =
        '<div class="row"><input type="hidden" class="form-control" name="additional_service_id[]"><div class="col-md-4"><div class="form-group"><input type="text" class="form-control" name="additional_service_name[]"  placeholder="' +
        name +
        '" required></div></div><div class="col-md-4"><div class="form-group"><input type="number" step="any" class="form-control numbers_only" name="additional_service_price[]"  placeholder="' +
        price +
        '" required></div></div><div class="col-md-4"><div class="form-group"><div class="d-flex gap-2"><input type="file" step="any" class="form-control" name="additional_service_image[]" required><button class="btn btn-danger" type="button" onclick="remove_editadditional_service_fields(' +
        editservice +
        ');"><i class="fa-solid fa-trash"></i></button></div></div></div></div>';
    $("span.hiddenextrascount:last()").html(editservice);
    $("#more_editadditional_service_fields").append(editdivtest);
    if ($("#more_editadditional_service_fields").find(".form-group").length > 1) {
        $(".additional_service_name, .additional_service_price").prop("required", true);
    }
}

function remove_editadditional_service_fields(rid) {
    "use strict";
    $(".editextrasclass" + rid).remove();
    if ($("#more_editadditional_service_fields").find(".form-group").length == 0) {
        $(".additional_service_name, .additional_service_price").prop("required", false);
    }
}



function deleteadditional(nexturl) {
  "use strict";
  const swalWithBootstrapButtons = Swal.mixin({
    customClass: {
      confirmButton: "btn btn-success mx-1",
      cancelButton: "btn btn-danger mx-1"
    },

    buttonsStyling: false
  });

  swalWithBootstrapButtons
    .fire({
      title: are_you_sure,

      icon: "warning",

      showCancelButton: true,

      confirmButtonText: yes,

      cancelButtonText: no,

      reverseButtons: true
    })
    .then(result => {
      if (result.isConfirmed) {
        location.href = nexturl;
      } else {
        result.dismiss === Swal.DismissReason.cancel;
      }
    });
}
