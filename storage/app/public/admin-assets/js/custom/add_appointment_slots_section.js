// Add Appointments Slots
$("#addappointments").on('click',function() {
  "use strict";
  var html =
    '<div class="row mb-3 px-2" id="removeappointments' +
    i +
    '"><div class="col-10"><div class="row"><div class="col-6"><input type="time" class="form-control"name="start_time[]"></div><div class="col-6"><input type="time" class="form-control" name="end_time[]"></div></div></div><div class="col-2"><a class="btn btn-danger" onclick="remove_appointments_field(' +
    i +
    ')"><i class="fa fa-trash"></i></a></div></div>';

  $("#appointment_repeater").append(html);

  $("#appointments_info").show();

  i++;
});

// Remove Appointments Slots
function remove_appointments_field(id) {
  "use strict";
  $("#removeappointments" + id).remove();
  if ($("#appointment_repeater .row").length == 0) {
    $("#appointments_info").hide();
  }
}
