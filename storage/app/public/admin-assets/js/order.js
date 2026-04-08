function payment(order_number, total, payment_type, screenshot) {
  "use strict";
  $("#order_number").val(order_number);
  $("#payment_type").val(payment_type);
  $("#modal_total_amount").val(total);
  if (payment_type == 1) {
    $("#cod_payment").removeClass("d-none");
    $("#bank_payment").addClass("d-none");
    $("#modal_amount").prop("required", true);
  }
  if (payment_type == 6) {
    $("#cod_payment").addClass("d-none");
    $("#bank_payment").removeClass("d-none");
    $("#bank_detail").attr("src", screenshot);
    $("#modal_amount").prop("required", false);
  }

  if (payment_type == "") {
    $("#modal_amount").prop("required", true);
    $("#cod_payment").removeClass("d-none");
    $("#bank_payment").addClass("d-none");
  }
  $("#cod_payment_modal").modal("show");
}

function validation(value) {
  var remaining = $("#modal_total_amount").val() - value;
  $("#ramin_amount").val(remaining.toFixed(2));
}
