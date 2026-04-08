// Add Service Card
$("#addservices").on('click',function() {
    "use strict";
    var html =
        '<div class="col-sm-6 col-md-4 mb-3" id="removeservice' + i + '"><div class="card border-0 box-shadow"><div class="img-overlay"><a class="btn btn-danger btn-sm" onclick="remove_service_card(' + i + ')"><i class="fa fa-trash"></i></a></div><div class="card-body mt-4"><input type="file" class="form-control mb-2" name="service_img[]" required><input type="text" class="form-control mb-2" name="services_title[]" placeholder="'+services_title+'" required><input type="text" class="form-control mb-2" name="description[]" placeholder="'+description+'" required><input type="text" class="form-control mb-2" name="purchase_link[]" placeholder="'+purchase_link+'" required><input type="text" class="form-control mb-2" name="link_title[]" placeholder="'+link_title+'" required></div></div></div>';

    $("#service_repeater").append(html);

    $('#services_card').show();

    i++;


})

// Remove Service Card
function remove_service_card(id) {
    "use strict";
    $('#removeservice' + id).remove();
    if ($('#service_repeater .card').length == 0) {
        $('#services_card').hide();
    }
}

