function check_data_empty() {
  "use strict";
  let check = 0;
  $(
    ".personal-info .form-control, .billing-info .form-control, shipping-info .form-select"
  ).each(function (index) {
    if ($(this).prop("tagName") !== "TEXTAREA" && $(this).attr("id") !== "tips_amount") {
      if ($(this).val() == "") {
        $(this).addClass("is-invalid").focus();
        check = 0;
        return false;
      } else if ($(this).attr("type") == "email") {
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;

        if (regex.test($(this).val()) == false) {
          $(this).addClass("is-invalid").focus();

          check = 0;

          return false;
        } else {
          $(this).removeClass("is-invalid").addClass("is-valid");
        }
      } else {
        $(this).removeClass("is-invalid").addClass("is-valid");

        check = 1;
      }
    }
  });
  if (
    check == 1 &&
    $(".shipping-area-info .form-select").find(":selected").val() == ""
  ) {
    $(".shipping-area-info .form-select").addClass("is-invalid").focus();

    check = 0;

    return false;
  } else if (
    check == 1 &&
    $(".shipping-area-info .form-select").find(":selected").val() != ""
  ) {
    $(".shipping-area-info .form-select")
      .removeClass("is-invalid")
      .addClass("is-valid");

    check = 1;
  }

  return check;
}

if (
  parseFloat(min_order_amount_for_free_shipping) >=
  parseFloat($("#subtotal").val())
) {
  $("#shipping_area").on("change", function () {
    "use strict";

    let delivery_charge = parseFloat(
      $(this).find(":selected").attr("data-delivery-charge")
    );

    $(".delivery_charge").html(currency_formate(delivery_charge));
    let sub_total = parseFloat($("#subtotal").val());

    if ($("#discount_amount").val() == "") {
      var offer_amount = parseFloat(0);
    } else {
      var offer_amount = parseFloat($("#discount_amount").val());
    }

    let tax_amount = parseFloat($("#totaltax").val());

    let grand_total = sub_total - offer_amount + tax_amount + delivery_charge;

    $("#delivery_charge").val(delivery_charge);

    $("#grand_total").val(grand_total);

    $("#total_amount").text(currency_formate(grand_total));
  });
}

function placeorder() {
  "use strict";
  if (min_order_amount != null && min_order_amount != "") {
    if (parseInt(min_order_amount) > parseInt($("#subtotal").val())) {
      toastr.error(min_order_amount_msg + " " + min_order_amount);
      return false;
    }
  }
  if (check_data_empty() == 0) {
    return false;
  }
  if ($('input[name="paymentmode"]:checked').length <= 0) {
    toastr.error($("#paymentmode_message").val());
    return false;
  }

  $(".placeorder").prop("disabled", true);
  $(".placeorder").html('<div class="load"></div>');
  var api_key = $("input[name=paymentmode]:checked").val();
  var transaction_type = $("input:radio[name=paymentmode]:checked").attr(
    "data-transaction-type"
  );

  var transaction_currency = $("input:radio[name=paymentmode]:checked").attr(
    "data-currency"
  );


  if ($("#tips_amount").val() == "" || $("#tips_amount").val() == undefined) {
    var grand_total = ($("#grand_total").val());
    var tips = 0;
  }
  else {
    var grand_total = parseFloat($("#grand_total").val()) + parseFloat($("#tips_amount").val());
    var tips = parseFloat($("#tips_amount").val());
  }

  var user_name = $("#user_name").val();
  var user_email = $("#user_email").val();
  var user_mobile = $("#user_mobile").val();

  // -------------------- COD ----------------------

  if (transaction_type == "1") {
    callplaceorder(1, "");
  }

  // -------------------- Wallet ----------------------
  if (transaction_type == "16") {
    callplaceorder(16, "");
  }

  // ------------------ Razorpay -------------------

  if (transaction_type == "2") {
    var options = {
      key: api_key,
      amount: parseInt(grand_total * 100),
      name: title,
      description: description,
      image: "https://badges.razorpay.com/badge-light.png",
      handler: function (response) {
        callplaceorder(2, response.razorpay_payment_id);
      },
      modal: {
        ondismiss: function () {
          $(".placeorder").prop("disabled", false);
          $(".placeorder").html(checkout);
        }
      },
      prefill: {
        name: user_name,
        email: user_email,
        contact: user_mobile
      },
      theme: {
        color: "#366ed4"
      }
    };

    var rzp1 = new Razorpay(options);

    rzp1.open();
  }

  // ------------------ Stripe ---------------------

  if (transaction_type == "3") {
    if ($("#stripe_public_key").val() != null) {
      var stripe = Stripe($("#stripe_public_key").val());
      var card = stripe.elements().create("card", {
        style: {
          base: {
            fontSize: "16px",
            color: "#32325d"
          }
        }
      });
      card.mount("#card-element");
    }

    $(".stripe-form").removeClass("d-none");
    $("#stripemodel").modal("show");
    $("#stripemodel").on("hidden.bs.modal", function (e) {
      $(".placeorder").prop("disabled", false);
      $(".placeorder").html(checkout);
    });
    $("#btnstripepayment").on("click", function () {
      stripe.createToken(card).then(function (result) {
        "use strict";
        if (result.error) {
          toastr.error(result.error.message);
          return false;
        } else {
          $("#btnstripepayment").prop("disabled", true);
          $("#btn-close").addClass("d-none");
          callplaceorder(3, result.token.id);
        }
      });
    });
  }

  // ------------------ Flutterwave ----------------

  if (transaction_type == "4") {
    FlutterwaveCheckout({
      public_key: api_key,

      tx_ref: user_name,

      amount: grand_total,

      currency: transaction_currency,

      payment_options: "",

      customer: {
        name: user_name,

        email: user_email,

        phone_number: user_mobile
      },

      callback: function (response) {
        callplaceorder(4, response.flw_ref);
      },

      onclose: function () {
        $(".placeorder").prop("disabled", false);
        $(".placeorder").html(checkout);
      },

      customizations: {
        title: title,

        description: description,

        logo: "https://flutterwave.com/images/logo/logo-mark/full.svg"
      }
    });
  }

  // ------------------ Paystack -------------------

  if (transaction_type == "5") {
    let handler = PaystackPop.setup({
      key: api_key,

      email: user_email,

      amount: parseFloat(grand_total * 100),

      currency: transaction_currency, // Use USD for US Dollars OR GHS for Ghana Cedis

      ref: "trx_" + Math.random().toString(16).slice(2),

      label: "Paystack Order payment",

      onClose: function () {
        $(".placeorder").prop("disabled", false);
        $(".placeorder").html(checkout);
      },

      callback: function (response) {
        callplaceorder(5, response.trxref);
      }
    });

    handler.openIframe();
  }

  // ----------------- Mercado pago ----------------

  if (transaction_type == "7") {
    callplaceorder(7, "");
  }

  // ----------------- PayPal ----------------
  if (transaction_type == "8") {
    callplaceorder(8, "");
  }

  // ----------------- My Fatoorah ----------------
  if (transaction_type == "9") {
    callplaceorder(9, "");
  }

  // ----------------- toyyibpay ----------------
  if (transaction_type == "10") {
    callplaceorder(10, "");
  }

  // ----------------- phonepe ----------------
  if (transaction_type == "11") {
    callplaceorder(11, "");
  }

  // ----------------- paytab ----------------
  if (transaction_type == "12") {
    callplaceorder(12, "");
  }

  // ----------------- mollie ----------------
  if (transaction_type == "13") {
    callplaceorder(13, "");
  }

  // ----------------- khalti ----------------
  if (transaction_type == "14") {
    callplaceorder(14, "");
  }

  // ----------------- xendit ----------------
  if (transaction_type == "15") {
    callplaceorder(15, "");
  }

  // Banktransfer
  if (transaction_type == "6") {
    $("#bank_description").html(
      $("input[name=paymentmode]:checked").attr("data-bank-description")
    );
    $("#modal_vendor_id").val($("#vendor_id").val());
    $("#modal_vendor_slug").val($("#vendor_slug").val());
    $("#modal_name").val($("#user_name").val());
    $("#modal_email").val($("#user_email").val());
    $("#modal_mobile").val($("#user_mobile").val());
    $("#modal_address").val($("#address").val());
    $("#modal_landmark").val($("#landmark").val());
    $("#modal_postal_code").val($("#postal_code").val());
    $("#modal_city").val($("#city").val());
    $("#modal_state").val($("#state").val());
    $("#modal_country").val($("#country").val());
    $("#modal_delivery_charge").val(parseFloat($("#delivery_charge").val()));
    $("#modal_shipping_area").val(
      $("#shipping_area").find(":selected").attr("data-area-name")
    );
    $("#modal_grand_total").val(grand_total);
    $("#modal_tips").val(tips);
    $("#modal_sub_total").val($("#subtotal").val());
    $("#modal_tax").val($("#tax_amount").val());
    $("#modal_tax_name").val($("#tax_name").val());
    $("#modal_message").val($("#order_notes").val());
    $("#modal_buynow").val($("#buynow").val());
    $("#modal_transaction_type").val(transaction_type);
    $("#bankdetailmodalurl").attr("action", checkouturl + "/placeorder");
    $("#modalbankdetails").modal("show");
    $("#modalbankdetails").on("hidden.bs.modal", function (e) {
      $(".placeorder").prop("disabled", false);
      $(".placeorder").html(checkout);
    });
  }
}

function callplaceorder(transaction_type, transaction_id) {

  if ($("#tips_amount").val() == "" || $("#tips_amount").val() == undefined) {
    var grand_total = $("#grand_total").val();
    var tips = 0;
  }
  else {
    var grand_total = parseFloat($("#grand_total").val()) + parseFloat($("#tips_amount").val());
    var tips = parseFloat($("#tips_amount").val());
  }
  "use strict";
  var data = {};

  data["vendor_id"] = $("#vendor_id").val();

  data["vendor_slug"] = $("#vendor_slug").val();

  data["name"] = $("#user_name").val();

  data["email"] = $("#user_email").val();

  data["mobile"] = $("#user_mobile").val();

  data["address"] = $("#address").val();

  data["landmark"] = $("#landmark").val();

  data["postal_code"] = $("#postal_code").val();

  data["city"] = $("#city").val();

  data["state"] = $("#state").val();

  data["country"] = $("#country").val();

  data["shipping_area"] = $("#shipping_area")
    .find(":selected")
    .attr("data-area-name");

  data["delivery_charge"] = parseFloat($("#delivery_charge").val());

  data["grand_total"] = grand_total;

  data["tips"] = tips;

  data["sub_total"] = $("#subtotal").val();

  data["tax"] = $("#tax_amount").val();

  data["tax_name"] = $("#tax_name").val();

  data["message"] = $("#order_notes").val();

  data["offer_code"] = $("#couponcode").val();

  data["offer_amount"] = $("#discount_amount").val();

  data["payment_type"] = transaction_type;

  data["transaction_id"] = transaction_id;

  data["successurl"] = successurl;

  data["failureurl"] = failureurl;

  data["buynow"] = $("#buynow").val();

  data["return"] = 1;


  var ajaxurl = "";

  var ajaxurl = checkouturl + "/placeorder";

  if (transaction_type == "7") {
    ajaxurl = checkouturl + "/mercadoorder";
  }
  if (transaction_type == "8") {
    ajaxurl = checkouturl + "/paypalrequest";
  }

  if (transaction_type == "9") {
    ajaxurl = checkouturl + "/myfatoorahrequest";
  }

  if (transaction_type == "10") {
    ajaxurl = checkouturl + "/toyyibpayrequest";
  }

  if (transaction_type == "11") {
    ajaxurl = checkouturl + "/phoneperequest";
  }

  if (transaction_type == "12") {
    ajaxurl = checkouturl + "/paytabrequest";
  }

  if (transaction_type == "13") {
    ajaxurl = checkouturl + "/mollierequest";
  }

  if (transaction_type == "14") {
    ajaxurl = checkouturl + "/khaltirequest";
  }

  if (transaction_type == "15") {
    ajaxurl = checkouturl + "/xenditrequest";
  }
  $.ajax({
    headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content") },

    url: ajaxurl,

    data: data,

    method: "POST",

    success: function (response) {
      if (response.status == 1) {
        if (
          transaction_type != "7" &&
          transaction_type != "8" &&
          transaction_type != "9" &&
          transaction_type != "10" &&
          transaction_type != "11" &&
          transaction_type != "12" &&
          transaction_type != "13" &&
          transaction_type != "14" &&
          transaction_type != "15"
        ) {
          location.href = response.successurl;
        } else {
          if (transaction_type == 8) {
            $(".callpaypal").trigger("click");
          } else {
            location.href = response.url;
          }
        }
      } else {
        if (transaction_type == 3) {
          $("#btnstripepayment").prop("disabled", false);
          $("#btn-close").removeClass("d-none");
        } else {
          $(".placeorder").prop("disabled", false);
          $(".placeorder").html(checkout);
        }
        toastr.error(response.message);
        return false;
      }
    },
    error: function () {
      if (transaction_type == 3) {
        $("#btnstripepayment").prop("disabled", false);
        $("#btn-close").removeClass("d-none");
      } else {
        $(".placeorder").prop("disabled", false);
        $(".placeorder").html(checkout);
      }
      toastr.error(wrong);
      return false;
    }
  });
}
