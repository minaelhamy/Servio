// Add Contact Information Field
function add_contact_field(x) {
  "use strict";
  var icon = $(x).attr("data-icon");
  var name = $(x).attr("data-name");
  var unique_name = name.split(" ").join("");
  var check_icon = icon.split("'")[1].split(" ")[1];
  var html =
    '<div class="col-sm-6 form-group" id="removecontact' + i + '"><div class="d-flex mb-2"><div class="input-group"><span class="input-group-text">' +
    icon + '</span><input type="text" class="form-control" name="contact_info[]" id=' + unique_name.toLowerCase() + " placeholder=" + name + ' required><span class="input-group-text bg-danger text-white border-0 cursor-pointer" onclick="remove_contact_field(' +
    i + ')"><i class="fa fa-trash"></i></span></div></div><input type="hidden" class="form-control" name="icon[]" value="' + icon + '"> <input type="hidden" class="form-control" name="title[]" value="' + name + '"></div>';
  if ($("#contact_info_repeater #" + unique_name.toLowerCase()).length > 0 || $("#contact_info_repeater").find('.'+check_icon).length > 0) {
    toastr.error(different_option);
  } else {
    $("#contact_info_repeater").append(html);
    $("#contact_info_card").show();
  }
  $("#contactinfo").modal("toggle");
  i++;
}
// Remove Contact Information Field
function remove_contact_field(id) {
  "use strict";
  $("#removecontact" + id).remove();
  if ($("#contact_info_repeater .form-group").length == 0) {
    $("#contact_info_card").hide();
  }
}
