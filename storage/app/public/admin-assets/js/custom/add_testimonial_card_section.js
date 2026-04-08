// Add Testimonials Card
$("#addtestimonials").on('click',function() {
  "use strict";
  var html =
    '<div class="col-sm-4 mb-3" id="removetestimonial' +
    i +
    '"><div class="card border-0 box-shadow"><div class="img-overlay"><a class="btn btn-danger btn-sm" onclick="remove_testimonial_card(' +
    i +
    ')"><i class="fa fa-trash"></i></a></div><div class="card-body mt-4"><input type="file" class="form-control mb-2" name="testimonial_img[]"><select name="rating[]" class="form-select text-warning mb-2"><option class="text-warning" value="5" selected>★★★★★</option><option class="text-warning" value="4">★★★★</option><option class="text-warning" value="3">★★★</option><option class="text-warning" value="2">★★</option><option class="text-warning" value="1">★</option></select><input type="text" class="form-control mb-2" name="review[]"placeholder="' +
    review +
    '" required></div></div></div>';

  $("#testimonial_repeater").append(html);

  $("#testimonials_info").show();
  i++;
});

// Remove Testimonials Card
function remove_testimonial_card(id) {
  "use strict";
  $("#removetestimonial" + id).remove();
  if ($("#testimonial_repeater .card").length == 0) {
    $("#testimonials_info").hide();
  }
}
