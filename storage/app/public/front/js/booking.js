function Paymentgetway() {
  "use strict";
  var api_key = $("input[name=paymentmode]:checked").val();
  var currency = $("input[name=paymentmode]:checked").attr("data-currency");
  var payment_type = $("input[name=paymentmode]:checked").attr("data-transaction-type");
  if ($('input[name="paymentmode"]:checked').length <= 0) {
    toastr.error($("#paymentmode_message").val());
    return false;
  }

  $('#booking_payment').addClass("d-none");
  $('#booking_loader').removeClass('d-none');
  // wallet
  if (payment_type == "16") {
    $.ajax({
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
      },
      url: purchase_url,
      type: "post",
      dataType: "json",
      data: {
        grand_total: price,
        booking_number: booking_number,
        payment_type: payment_type,
        payment_id: ""
      },
      success: function (response) {
        if (response.status == 0) {
          $('#booking_payment').removeClass("d-none");
          $('#booking_loader').addClass('d-none');
          toastr.error(response.message);
          return false;
        } else {
          location.href = success_url;
        }
      },
      error: function () {
        $('#booking_payment').removeClass("d-none");
        $('#booking_loader').addClass('d-none');
        toastr.error(wrong);
      }
    });
  }

  // RazorPay
  if (payment_type == "2") {
    var options = {
      key: api_key,
      amount: price * 100, // 2000 paise = INR 20

      name: "BookingDo",
      description: "Service Booking Payment",
      image: "https://badges.razorpay.com/badge-light.png",
      handler: function (response) {
        $.ajax({
          headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
          },
          url: purchase_url,
          type: "post",
          dataType: "json",
          data: {
            grand_total: price,
            booking_number: booking_number,
            payment_type: payment_type,
            payment_id: response.razorpay_payment_id
          },
          success: function (response) {
            if (response.status == 0) {
              $('#booking_payment').removeClass("d-none");
              $('#booking_loader').addClass('d-none');
              toastr.error(response.message);
              return false;
            } else {
              location.href = success_url;
            }
          },
          error: function () {
            $('#booking_payment').removeClass("d-none");
            $('#booking_loader').addClass('d-none');
            toastr.error(wrong);
          }
        });
      },
      modal: {
        ondismiss: function () {
          $('#booking_payment').removeClass("d-none");
          $('#booking_loader').addClass('d-none');
        }
      },
      prefill: {
        name: customer_name,
        email: customer_email,
        contact: customer_mobile
      },
      theme: {
        color: "#528FF0"
      }
    };
    var rzp1 = new Razorpay(options);
    rzp1.open();
    e.preventDefault();
  }

  // Stripe
  if (payment_type == "3") {
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
    $("#stripemodel").on('hidden.bs.modal', function (e) {
      $('#booking_payment').removeClass("d-none");
      $('#booking_loader').addClass('d-none');
    });
    $("#btnstripepayment").on("click", function () {
      stripe.createToken(card).then(function (result) {
        if (result.error) {
          toastr.error(result.error.message);
          return false;
        } else {
          $("#btnstripepayment").prop("disabled", true);
          $("#btn-close").addClass("d-none");
          $.ajax({
            headers: {
              "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            url: purchase_url,
            type: "post",
            dataType: "json",
            data: {
              grand_total: price,
              booking_number: booking_number,
              currency: currency,
              payment_type: payment_type,
              payment_id: result.token.id
            },
            success: function (response) {
              if (response.status == 0) {
                $("#btn-close").removeClass("d-none");
                $("#btnstripepayment").prop("disabled", false);
                $('#booking_payment').removeClass("d-none");
                $('#booking_loader').addClass('d-none');
                toastr.error(response.message);
                return false;
              } else {
                location.href = success_url;
              }
            },
            error: function () {
              $("#btn-close").removeClass("d-none");
              $("#btnstripepayment").prop("disabled", false);
              $('#booking_payment').removeClass("d-none");
              $('#booking_loader').addClass('d-none');
              toastr.error(wrong);
            }
          });
        }
      });
    });
  }

  // Flutterwave
  if (payment_type == "4") {
    FlutterwaveCheckout({
      public_key: api_key,
      tx_ref: customer_name,
      amount: price,
      currency: currency,
      payment_options: "",
      customer: {
        email: customer_email,
        phone_number: customer_mobile,
        name: customer_name
      },
      callback: function (response) {
        $.ajax({
          headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
          },
          url: purchase_url,
          type: "post",
          dataType: "json",
          data: {
            grand_total: price,
            booking_number: booking_number,
            payment_type: payment_type,
            payment_id: response.flw_ref
          },
          success: function (response) {
            if (response.status == 0) {
              $('#booking_payment').removeClass("d-none");
              $('#booking_loader').addClass('d-none');
              toastr.error(response.message);
              return false;
            } else {
              window.location.href = success_url;
            }
          },
          error: function () {
            $('#booking_payment').removeClass("d-none");
            $('#booking_loader').addClass('d-none');
            toastr.error(wrong);
          }
        });
      },
      onclose: function () {
        $('#booking_payment').removeClass("d-none");
        $('#booking_loader').addClass('d-none');
      },
      customizations: {
        title: "Service Provider",
        description: "Flutterwave Order payment",
        logo: "https://flutterwave.com/images/logo/logo-mark/full.svg"
      }
    });
  }

  // Paystack
  if (payment_type == "5") {
    var handler = PaystackPop.setup({
      key: api_key,
      email: customer_email,
      amount: price * 100,
      currency: currency, // Use GHS for Ghana Cedis or USD for US Dollars

      callback: function (response) {
        $.ajax({
          headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
          },
          url: purchase_url,
          type: "post",
          dataType: "json",
          data: {
            grand_total: price,
            booking_number: booking_number,
            payment_type: payment_type,
            payment_id: response.reference
          },
          success: function (response) {
            if (response.status == 0) {
              $('#booking_payment').removeClass("d-none");
              $('#booking_loader').addClass('d-none');
              toastr.error(response.message);
              return false;
            } else {
              window.location.href = success_url;
            }
          },
          error: function () {
            $('#booking_payment').removeClass("d-none");
            $('#booking_loader').addClass('d-none');
            toastr.error(wrong);
          }
        });
      },
      onClose: function () {
        $('#booking_payment').removeClass("d-none");
        $('#booking_loader').addClass('d-none');
      }
    });
    handler.openIframe();
  }
  // banktransfer
  if (payment_type == '6') {
    $('#bank_description').html($('input[name=paymentmode]:checked').attr('data-bank-description'));
    $("#bankdetailmodalurl").attr('action', $("#url").val());
    $('#modal_booking_number').val(booking_number);
    $('#modal_payment_type').val("6");
    $('#modalbankdetails').modal('show');
    $("#modalbankdetails").on('hidden.bs.modal', function (e) {
      $('#booking_payment').removeClass("d-none");
      $('#booking_loader').addClass('d-none');
    });
  }

  // mercadopago
  if (payment_type == "7") {
    $.ajax({
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
      },
      url: mercado_url,
      type: "post",
      dataType: "json",
      data: {
        vendor_id: vendor_id,
        grand_total: price,
        name: customer_name,
        customer_email: customer_email,
        booking_number: booking_number,
        payment_type: payment_type,
        successurl: mercado_successurl,
        failureurl: mercado_successurl
      },
      success: function (response) {
        if (response.status == 1) {
          window.location.href = response.url;
        } else {
          $('#booking_payment').removeClass("d-none");
          $('#booking_loader').addClass('d-none');
          toastr.error(response.message);
          return false;
        }
      },
      error: function () {
        $('#booking_payment').removeClass("d-none");
        $('#booking_loader').addClass('d-none');
        toastr.error(wrong);
      }
    });
  }

  //PayPal
  if (payment_type == "8") {
    $.ajax({
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
      },
      url: paypal_url,
      data: {
        vendor_id: vendor_id,
        grand_total: price,
        name: customer_name,
        customer_email: customer_email,
        booking_number: booking_number,
        return: "1",
        payment_type: payment_type,
        successurl: mercado_successurl,
        failureurl: mercado_successurl
      },
      method: "POST",
      dataType: "json",
      success: function (response) {
        if (response.status == 1) {
          $(".callpaypal").trigger("click");
        } else {
          $('#booking_payment').removeClass("d-none");
          $('#booking_loader').addClass('d-none');
          toastr.error(response.message);
          return false;
        }
      },
      error: function () {
        $('#booking_payment').removeClass("d-none");
        $('#booking_loader').addClass('d-none');
        toastr.error(wrong);
      }
    });
  }

  // myfatoorah
  if (payment_type == "9") {
    $.ajax({
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
      },
      url: myfatoorah_url,
      data: {
        vendor_id: vendor_id,
        grand_total: price,
        name: customer_name,
        customer_email: customer_email,
        booking_number: booking_number,
        payment_type: payment_type,
        successurl: mercado_successurl,
        failureurl: mercado_successurl
      },
      method: "POST",
      dataType: "json",
      success: function (response) {
        if (response.status == 1) {
          window.location.href = response.url;
        } else {
          $('#booking_payment').removeClass("d-none");
          $('#booking_loader').addClass('d-none');
          toastr.error(response.message);
          return false;
        }
      },
      error: function () {
        $('#booking_payment').removeClass("d-none");
        $('#booking_loader').addClass('d-none');
        toastr.error(wrong);
        return false;
      }
    });
  }

  //toyyibpay
  if (payment_type == "10") {
    $.ajax({
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
      },
      url: toyyibpay_url,
      data: {
        vendor_id: vendor_id,
        grand_total: price,
        name: customer_name,
        customer_email: customer_email,
        booking_number: booking_number,
        payment_type: payment_type,
        successurl: mercado_successurl,
        failureurl: mercado_successurl
      },
      method: "POST",
      dataType: "json",
      success: function (response) {
        if (response.status == 1) {
          window.location.href = response.url;
        } else {
          $('#booking_payment').removeClass("d-none");
          $('#booking_loader').addClass('d-none');
          toastr.error(response.message);
          return false;
        }
      },
      error: function () {
        $('#booking_payment').removeClass("d-none");
        $('#booking_loader').addClass('d-none');
        toastr.error(wrong);
        return false;
      }
    });
  }

  //phonepe
  if (payment_type == "11") {
    $.ajax({
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
      },
      url: phonepe_url,
      data: {
        vendor_id: vendor_id,
        grand_total: price,
        name: customer_name,
        customer_email: customer_email,
        booking_number: booking_number,
        payment_type: payment_type,
        successurl: mercado_successurl,
        failureurl: mercado_successurl
      },
      method: "POST",
      dataType: "json",
      success: function (response) {
        if (response.status == 1) {
          window.location.href = response.url;
        } else {
          $('#booking_payment').removeClass("d-none");
          $('#booking_loader').addClass('d-none');
          toastr.error(response.message);
          return false;
        }
      },
      error: function () {
        $('#booking_payment').removeClass("d-none");
        $('#booking_loader').addClass('d-none');
        toastr.error(wrong);
        return false;
      }
    });
  }

  //paytab
  if (payment_type == "12") {
    $.ajax({
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
      },
      url: paytab_url,
      data: {
        vendor_id: vendor_id,
        grand_total: price,
        name: customer_name,
        customer_email: customer_email,
        booking_number: booking_number,
        payment_type: payment_type,
        successurl: mercado_successurl,
        failureurl: mercado_successurl
      },
      method: "POST",
      dataType: "json",
      success: function (response) {
        if (response.status == 1) {
          window.location.href = response.url;
        } else {
          $('#booking_payment').removeClass("d-none");
          $('#booking_loader').addClass('d-none');
          toastr.error(response.message);
          return false;
        }
      },
      error: function () {
        $('#booking_payment').removeClass("d-none");
        $('#booking_loader').addClass('d-none');
        toastr.error(wrong);
        return false;
      }
    });
  }

  //mollie
  if (payment_type == "13") {
    $.ajax({
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
      },
      url: mollie_url,
      data: {
        vendor_id: vendor_id,
        grand_total: price,
        name: customer_name,
        customer_email: customer_email,
        booking_number: booking_number,
        payment_type: payment_type,
        successurl: mercado_successurl,
        failureurl: mercado_successurl
      },
      method: "POST",
      dataType: "json",
      success: function (response) {
        if (response.status == 1) {
          window.location.href = response.url;
        } else {
          $('#booking_payment').removeClass("d-none");
          $('#booking_loader').addClass('d-none');
          toastr.error(response.message);
          return false;
        }
      },
      error: function () {
        $('#booking_payment').removeClass("d-none");
        $('#booking_loader').addClass('d-none');
        toastr.error(wrong);
        return false;
      }
    });
  }

  //khalti
  if (payment_type == "14") {
    $.ajax({
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
      },
      url: khalti_url,
      data: {
        vendor_id: vendor_id,
        grand_total: price,
        name: customer_name,
        customer_email: customer_email,
        booking_number: booking_number,
        payment_type: payment_type,
        successurl: mercado_successurl,
        failureurl: mercado_successurl
      },
      method: "POST",
      dataType: "json",
      success: function (response) {
        if (response.status == 1) {
          window.location.href = response.url;
        } else {
          $('#booking_payment').removeClass("d-none");
          $('#booking_loader').addClass('d-none');
          toastr.error(response.message);
          return false;
        }
      },
      error: function () {
        $('#booking_payment').removeClass("d-none");
        $('#booking_loader').addClass('d-none');
        toastr.error(wrong);
        return false;
      }
    });
  }

  //xendit
  if (payment_type == "15") {
    $.ajax({
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
      },
      url: xendit_url,
      data: {
        vendor_id: vendor_id,
        grand_total: price,
        name: customer_name,
        customer_email: customer_email,
        booking_number: booking_number,
        payment_type: payment_type,
        successurl: mercado_successurl,
        failureurl: mercado_successurl
      },
      method: "POST",
      dataType: "json",
      success: function (response) {
        if (response.status == 1) {
          window.location.href = response.url;
        } else {
          $('#booking_payment').removeClass("d-none");
          $('#booking_loader').addClass('d-none');
          toastr.error(response.message);
          return false;
        }
      },
      error: function () {
        $('#booking_payment').removeClass("d-none");
        $('#booking_loader').addClass('d-none');
        toastr.error(wrong);
        return false;
      }
    });
  }
  var x = document.getElementById("paynow");
  x.classList.remove("d-none");
}

function copyText() {
  "use strict";
  var copyText = document.getElementById("myInput");
  copyText.select();
  copyText.setSelectionRange(0, 99999);
  document.execCommand("copy");
  var tooltip = document.getElementById("myTooltip");
  tooltip.innerHTML = "Copied";
}
