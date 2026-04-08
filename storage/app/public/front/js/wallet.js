if (document.getElementById("stripe") && $("#stripe").val() !== "") {
  var stripe = Stripe($("#stripe").val());
  var card = stripe.elements().create("card", {
    style: {
      base: {
        // Add your base input styles here. For example:
        fontSize: "16px",
        color: "#32325d"
      }
    }
  });
  card.mount("#card-element");
  $(".__PrivateStripeElement iframe").css({
    height: "50px",
    width: "100%",
    border: "1px solid #e5e5e5",
    "border-radius": "6px",
    display: "block",
    padding: "15px",
    "box-shadow": "0 0 6px rgba(0, 0, 0654, .3)"
  });
}
// TO-HIDE-PAYMENT-TYPE-ERROR
$("input:radio[name=transaction_type]").on("click", function (event) {
  "use strict";
  if ($(this).val() == 3) {
    $("#card-element").removeClass("d-none");
  } else {
    $("#card-element").addClass("d-none");
  }
});
function addmoney() {
  "use strict";
  if ($("#amount").val() == null || $("#amount").val() <= 0) {
    toastr.error($("#amount_message").val());
    return false;
  }
  if ($('input[name="transaction_type"]:checked').length <= 0) {
    toastr.error($("#payment_type_message").val());
    return false;
  }
  $('.wallet_recharge').prop("disabled", true);
  $('.wallet_recharge').html('<div class="load"></div>');

  var mercadopagourl = $("#mercadopagourl").val();
  var myfatoorahurl = $("#myfatoorahurl").val();
  var toyyibpayurl = $("#toyyibpayurl").val();
  var paypalurl = $("#paypalurl").val();
  var paytaburl = $("#paytaburl").val();
  var phonepeurl = $("#phonepeurl").val();
  var mollieurl = $("#mollieurl").val();
  var khaltiurl = $("#khaltiurl").val();
  var xenditurl = $("#xenditurl").val();

  var walleturl = $("#walleturl").val();
  var successurl = $("#successurl").val();
  var addsuccessurl = $("#addsuccessurl").val();
  var addfailurl = $("#addfailurl").val();

  var user_name = $("#user_name").val();
  var user_email = $("#user_email").val();
  var user_mobile = $("#user_mobile").val();
  var vendor_id = $("#vendor_id").val();
  var amount = $("#amount").val();
  var transaction_type = $("input:radio[name=transaction_type]:checked").val();
  var transaction_currency = $("input:radio[name=transaction_type]:checked").attr("data-currency");
  var slug = $("#slug").val();
  var flutterwavekey = $("#flutterwavekey").val();
  //Razorpay
  if (transaction_type == 2) {
    var options = {
      key: $("#razorpay").val(),
      amount: parseInt(amount * 100),
      name: "BookingDo",
      description: "Razorpay Wallet payment",
      image: "https://badges.razorpay.com/badge-light.png",
      handler: function (response) {
        $.ajax({
          headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
          },
          url: walleturl,
          type: "post",
          dataType: "json",
          data: {
            amount: amount,
            payment_type: transaction_type,
            transaction_id: response.razorpay_payment_id,
            vendor_id: vendor_id,
          },
          success: function (response) {
            console.log(response);

            if (response.status == 1) {
              window.location.href = successurl;
            } else {
              toastr.error(response.message);
              $('.wallet_recharge').prop("disabled", false);
              $('.wallet_recharge').html('Proceed To Pay');
              return false;
            }
          },
          error: function () {
            toastr.error(wrong);
            $('.wallet_recharge').prop("disabled", false);
            $('.wallet_recharge').html('Proceed To Pay');
            return false;
          }
        });
      },
      modal: {
        ondismiss: function () {
          $('.wallet_recharge').prop("disabled", false);
          $('.wallet_recharge').html('Proceed To Pay');
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

  // stripe
  if (transaction_type == "3") {
    stripe.createToken(card).then(function (result) {
      if (result.error) {
        toastr.error(result.error.message);
        $('.wallet_recharge').prop("disabled", false);
        $('.wallet_recharge').html('Proceed To Pay');
        return false;
      } else {
        $.ajax({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          url: walleturl,
          data: {
            amount: amount,
            payment_type: transaction_type,
            transaction_id: result.token.id,
            vendor_id: vendor_id
          },
          method: 'POST',
          success: function (response) {
            if (response.status == 1) {
              window.location.href = successurl;
            } else {
              toastr.error(response.message);
              $('.wallet_recharge').prop("disabled", false);
              $('.wallet_recharge').html('Proceed To Pay');
              return false;
            }
          },
          error: function () {
            toastr.error(wrong);
            $('.wallet_recharge').prop("disabled", false);
            $('.wallet_recharge').html('Proceed To Pay');
            return false;
          }
        });
      }
    });
  }

  //Flutterwave
  if (transaction_type == 4) {
    FlutterwaveCheckout({
      public_key: flutterwavekey,
      tx_ref: user_name,
      amount: amount,
      currency: transaction_currency,
      payment_options: "",
      customer: {
        name: user_name,
        email: user_email,
        phone_number: user_mobile,
        vendor_id: vendor_id,
      },
      callback: function (data) {
        $.ajax({
          headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
          },
          url: walleturl,
          method: "POST",
          dataType: "json",
          data: {
            amount: amount,
            payment_type: transaction_type,
            transaction_id: data.flw_ref
          },
          success: function (response) {
            console.log(response);

            if (response.status == 1) {
              window.location.href = successurl;
            } else {
              toastr.error(response.message);
              $('.wallet_recharge').prop("disabled", false);
              $('.wallet_recharge').html('Proceed To Pay');
              return false;
            }
          },
          error: function () {
            toastr.error(wrong);
            $('.wallet_recharge').prop("disabled", false);
            $('.wallet_recharge').html('Proceed To Pay');
            return false;
          }
        });
      },
      onclose: function () {
        $('.wallet_recharge').prop("disabled", false);
        $('.wallet_recharge').html('Proceed To Pay');
      },
      customizations: {
        title: "BookingDo",
        description: "Flutterwave Order payment",
        logo: "https://flutterwave.com/images/logo/logo-mark/full.svg"
      }
    });
  }

  //Paystack
  if (transaction_type == 5) {
    let handler = PaystackPop.setup({
      key: $("#paystackkey").val(),
      email: user_email,
      amount: amount * 100,
      currency: transaction_currency, // Use GHS for Ghana Cedis or USD for US Dollars
      ref: "trx_" + Math.random().toString(16).slice(2),
      label: "Paystack Order payment",
      onClose: function () {
        $('.wallet_recharge').prop("disabled", false);
        $('.wallet_recharge').html('Proceed To Pay');
      },
      callback: function (response) {
        $.ajax({
          headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
          },
          url: walleturl,
          data: {
            amount: amount,
            payment_type: transaction_type,
            transaction_id: response.trxref,
            vendor_id: vendor_id,
          },
          method: "POST",
          success: function (response) {
            if (response.status == 1) {
              window.location.href = successurl;
            } else {
              toastr.error(response.message);
              $('.wallet_recharge').prop("disabled", false);
              $('.wallet_recharge').html('Proceed To Pay');
              return false;
            }
          },
          error: function () {
            toastr.error(wrong);
            $('.wallet_recharge').prop("disabled", false);
            $('.wallet_recharge').html('Proceed To Pay');
            return false;
          }
        });
      }
    });
    handler.openIframe();
  }

  //MercadoPago
  if (transaction_type == 7) {
    $.ajax({
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
      },
      url: mercadopagourl,
      data: {
        grand_total: amount,
        payment_type: transaction_type,
        user_name: user_name,
        user_mobile: user_mobile,
        user_email: user_email,
        successurl: addsuccessurl,
        failurl: addfailurl,
        vendor_id: vendor_id,
        vendor_slug: slug
      },
      method: "POST",
      success: function (response) {
        if (response.status == 1) {
          window.location.href = response.url;
        } else {
          toastr.error(response.message);
          $('.wallet_recharge').prop("disabled", false);
          $('.wallet_recharge').html('Proceed To Pay');
          return false;
        }
      },
      error: function () {
        toastr.error(wrong);
        $('.wallet_recharge').prop("disabled", false);
        $('.wallet_recharge').html('Proceed To Pay');
        return false;
      }
    });
  }

  //paypal
  if (transaction_type == 8) {
    $.ajax({
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
      },
      url: paypalurl,
      data: {
        grand_total: amount,
        payment_type: transaction_type,
        name: user_name,
        mobile: user_mobile,
        email: user_email,
        successurl: addsuccessurl,
        failureurl: addfailurl,
        vendor_id: vendor_id,
        vendor_slug: slug,
        return: 1,
      },
      method: "POST",
      success: function (response) {
        $(".callpaypal").trigger("click");
      },
      error: function () {
        toastr.error(wrong);
        $('.wallet_recharge').prop("disabled", false);
        $('.wallet_recharge').html('Proceed To Pay');
        return false;
      }
    });
  }

  //myfatoorah
  if (transaction_type == 9) {
    $.ajax({
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
      },
      url: myfatoorahurl,
      data: {
        grand_total: amount,
        payment_type: transaction_type,
        name: user_name,
        mobile: user_mobile,
        email: user_email,
        successurl: addsuccessurl,
        failureurl: addfailurl,
        vendor_id: vendor_id,
        vendor_slug: slug,
        return: '1',
      },
      method: "POST",
      success: function (response) {
        if (response.status == 1) {
          window.location.href = response.url;
        } else {
          toastr.error(response.message);
          $('.wallet_recharge').prop("disabled", false);
          $('.wallet_recharge').html('Proceed To Pay');
          return false;
        }
      },
      error: function () {
        toastr.error(wrong);
        $('.wallet_recharge').prop("disabled", false);
        $('.wallet_recharge').html('Proceed To Pay');
        return false;
      }
    });
  }

  //toyyibpay
  if (transaction_type == 10) {
    $.ajax({
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
      },
      url: toyyibpayurl,
      data: {
        grand_total: amount,
        payment_type: transaction_type,
        name: user_name,
        mobile: user_mobile,
        email: user_email,
        successurl: addsuccessurl,
        failureurl: addfailurl,
        vendor_id: vendor_id,
        vendor_slug: slug,
      },
      method: "POST",
      success: function (response) {
        if (response.status == 1) {
          window.location.href = response.url;
        } else {
          toastr.error(response.message);
          $('.wallet_recharge').prop("disabled", false);
          $('.wallet_recharge').html('Proceed To Pay');
          return false;
        }
      },
      error: function () {
        toastr.error(wrong);
        $('.wallet_recharge').prop("disabled", false);
        $('.wallet_recharge').html('Proceed To Pay');
        return false;
      }
    });
  }

  //phonepe
  if (transaction_type == 11) {
    $.ajax({
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
      },
      url: phonepeurl,
      data: {
        grand_total: amount,
        payment_type: transaction_type,
        name: user_name,
        mobile: user_mobile,
        email: user_email,
        successurl: addsuccessurl,
        failureurl: addfailurl,
        vendor_id: vendor_id,
        vendor_slug: slug,

      },
      method: "POST",
      success: function (response) {
        if (response.status == 1) {
          window.location.href = response.url;
        } else {
          toastr.error(response.message);
          $('.wallet_recharge').prop("disabled", false);
          $('.wallet_recharge').html('Proceed To Pay');
          return false;
        }
      },
      error: function () {
        toastr.error(wrong);
        $('.wallet_recharge').prop("disabled", false);
        $('.wallet_recharge').html('Proceed To Pay');
        return false;
      }
    });
  }

  //paytab
  if (transaction_type == 12) {
    $.ajax({
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
      },
      url: paytaburl,
      data: {
        grand_total: amount,
        payment_type: transaction_type,
        name: user_name,
        mobile: user_mobile,
        email: user_email,
        successurl: addsuccessurl,
        failureurl: addfailurl,
        vendor_id: vendor_id,
        vendor_slug: slug,
      },
      method: "POST",
      success: function (response) {
        if (response.status == 1) {
          window.location.href = response.url;
        } else {
          toastr.error(response.message);
          $('.wallet_recharge').prop("disabled", false);
          $('.wallet_recharge').html('Proceed To Pay');
          return false;
        }
      },
      error: function () {
        toastr.error(wrong);
        $('.wallet_recharge').prop("disabled", false);
        $('.wallet_recharge').html('Proceed To Pay');
        return false;
      }
    });
  }

  //mollie
  if (transaction_type == 13) {
    $.ajax({
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
      },
      url: mollieurl,
      data: {
        grand_total: amount,
        payment_type: transaction_type,
        name: user_name,
        mobile: user_mobile,
        email: user_email,
        successurl: addsuccessurl,
        failureurl: addfailurl,
        vendor_id: vendor_id,
        vendor_slug: slug,
      },
      method: "POST",
      success: function (response) {
        if (response.status == 1) {
          window.location.href = response.url;
        } else {
          toastr.error(response.message);
          $('.wallet_recharge').prop("disabled", false);
          $('.wallet_recharge').html('Proceed To Pay');
          return false;
        }
      },
      error: function () {
        toastr.error(wrong);
        $('.wallet_recharge').prop("disabled", false);
        $('.wallet_recharge').html('Proceed To Pay');
        return false;
      }
    });
  }

  //khalti
  if (transaction_type == 14) {
    $.ajax({
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
      },
      url: khaltiurl,
      data: {
        grand_total: amount,
        payment_type: transaction_type,
        name: user_name,
        mobile: user_mobile,
        email: user_email,
        successurl: addsuccessurl,
        failureurl: addfailurl,
        vendor_id: vendor_id,
        vendor_slug: slug,
      },
      method: "POST",
      success: function (response) {
        if (response.status == 1) {
          window.location.href = response.url;
        } else {
          toastr.error(response.message);
          $('.wallet_recharge').prop("disabled", false);
          $('.wallet_recharge').html('Proceed To Pay');
          return false;
        }
      },
      error: function () {
        toastr.error(wrong);
        $('.wallet_recharge').prop("disabled", false);
        $('.wallet_recharge').html('Proceed To Pay');
        return false;
      }
    });
  }

  //xendit
  if (transaction_type == 15) {
    $.ajax({
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
      },
      url: xenditurl,
      data: {
        grand_total: amount,
        payment_type: transaction_type,
        name: user_name,
        mobile: user_mobile,
        email: user_email,
        successurl: addsuccessurl,
        failureurl: addfailurl,
        vendor_id: vendor_id,
        vendor_slug: slug,
      },
      method: "POST",
      success: function (response) {
        if (response.status == 1) {
          window.location.href = response.url;
        } else {
          toastr.error(response.message);
          $('.wallet_recharge').prop("disabled", false);
          $('.wallet_recharge').html('Proceed To Pay');
          return false;
        }
      },
      error: function () {
        toastr.error(wrong);
        $('.wallet_recharge').prop("disabled", false);
        $('.wallet_recharge').html('Proceed To Pay');
        return false;
      }
    });
  }

}
