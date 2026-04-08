// Add Social Links Field
function add_sociallinks(x) {
    "use strict";
    var icon = $(x).attr('data-icon');
    var name = $(x).attr('data-name');
    var unique_name = name.split(" ").join("");
    var check_icon = icon.split("'")[1].split(" ")[1]; 
    var html ='<div class="col-sm-6 form-group" id="removesocial' + i + '"><div class="d-flex mb-2"><div class="input-group"><span class="input-group-text">' + icon + '</span><input type="text" class="form-control" name="social_info[]" id=' + unique_name.toLowerCase() + ' placeholder=' + name + ' required></div><button type="button" class="btn btn-danger mx-2 btn-sm" onclick="remove_social_links_field(' + i + ')"><i class="fa fa-trash"></i></button></div><input type="hidden" class="form-control" name="icon[]" value="' + icon + '"> <input type="hidden" class="form-control" name="title[]" value="' + unique_name + '"></div>';
    if ($('#social_links_repeater #' + unique_name.toLowerCase()).length > 0 || $("#social_links_repeater").find('.'+check_icon).length > 0) {
        toastr.error(different_option);
    } else {
        $("#social_links_repeater").append(html);
        $('#social_links_info').show();
    }
    $('#sociallinks').modal('toggle');
    i++;
    }
// Remove Social Links Field
function remove_social_links_field(id) {
    "use strict";
    $('#removesocial' + id).remove();
    if ($('#social_links_repeater .form-group').length == 0) {
        $('#social_links_info').hide();
    }
}
