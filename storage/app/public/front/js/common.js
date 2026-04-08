// datatable
$(document).ready(function () {
  "use strict";

  $(".zero-configuration").DataTable({
    dom: "Bfrtip",

    buttons: ["excelHtml5", "pdfHtml5"]
  });
});

$(window).on("scroll", function () {
  "use strict";
  if ($(window).scrollTop() > 1150) {
    if ($(window).width() > 768) {
      $(".view-cart-bar").removeClass("d-none");
    } else {
      $(".view-cart-bar").addClass("d-none");
    }
  } else {
    $(".view-cart-bar").addClass("d-none");
  }
});

function addtocart(product_id, addcarturl, buynow) {
  "use strict";

  if (buynow == 0) {
    $(".add_to_cart_" + product_id).prop("disabled", true);
    $(".add_to_cart_icon_" + product_id).addClass("d-none");
    $(".add_to_cart_loader_" + product_id).removeClass("d-none");
  } else {
    $(".buy_now_" + product_id).prop("disabled", true);
    $(".buy_now_icon_" + product_id).addClass("d-none");
    $(".buy_now_loader_" + product_id).removeClass("d-none");
  }
  $.ajax({
    headers: {
      "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
    },
    url: addcarturl,
    data: {
      product_id: product_id,
      buynow: buynow
    },
    method: "POST",
    dataType: "json",
    success: function (response) {
      if (response.status == 1) {
        if (buynow == 1) {
          if (customerlogin != 2 && customerlogin.activated == 1) {
            if (is_logedin == 1) {
              location.href = "checkout?buynow=1";
            } else if (login_required == 1) {
              if (checkout_login_required == 1) {
                location.href = loginurl;
              } else {
                $("#orderloginmodal").modal("show");
                $("#orderloginmodal").on("hidden.bs.modal", function (e) {
                  $(".buy_now_" + product_id).prop("disabled", false);
                  $(".buy_now_icon_" + product_id).removeClass("d-none");
                  $(".buy_now_loader_" + product_id).addClass("d-none");
                });
              }
            } else {
              location.href = "checkout?buynow=1";
            }
          } else {
            location.href = "checkout?buynow=1";
          }
        } else {
          $(".add_to_cart_" + product_id).prop("disabled", false);
          $(".add_to_cart_icon_" + product_id).removeClass("d-none");
          $(".add_to_cart_loader_" + product_id).addClass("d-none");
          toastr.success(response.message);
          $(".cart-count").html(response.total_cart_count);
        }
      } else {
        $(".buy_now_" + product_id).prop("disabled", false);
        $(".buy_now_icon_" + product_id).removeClass("d-none");
        $(".buy_now_loader_" + product_id).addClass("d-none");
        $(".add_to_cart_" + product_id).prop("disabled", false);
        $(".add_to_cart_icon_" + product_id).removeClass("d-none");
        $(".add_to_cart_loader_" + product_id).addClass("d-none");
        toastr.error(response.message);
        return false;
      }
    },
    error: function () {
      $(".buy_now_" + product_id).prop("disabled", false);
      $(".buy_now_icon_" + product_id).removeClass("d-none");
      $(".buy_now_loader_" + product_id).addClass("d-none");
      $(".add_to_cart_" + product_id).prop("disabled", false);
      $(".add_to_cart_icon_" + product_id).removeClass("d-none");
      $(".add_to_cart_loader_" + product_id).addClass("d-none");
      toastr.error(wrong);
      return false;
    }
  });
}

function qtyupdate(cart_id, item_id, type) {
  $(".change-qty").prop("disabled", true);
  $.ajax({
    headers: {
      "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
    },
    url: qtycheckurl,
    data: {
      cart_id: cart_id,
      item_id: item_id,
      type: type
    },
    method: "POST",
    success: function (response) {
      if (response.status == 1) {
        location.reload();
      } else {
        $(".change-qty").prop("disabled", false);
        toastr.error(response.message);
        return false;
      }
    },
    error: function () {
      $(".change-qty").prop("disabled", false);
      toastr.error(wrong);
      return false;
    }
  });
}

$(".copy").on("click", function () {
  "use strict";
  $("#offer_code").val($(this).attr("data-code"));
});

function checkout() {
  var request_url = $("#request_url").val();
  if (request_url == "cartproduct") {
    location.href = "checkout?buynow=0";
  } else {
    location.href = "checkout?buynow=1";
  }
}

const slideValue = document.querySelector("span");
const inputSlider = document.querySelector("input");

inputSlider.oninput = () => {
  let value = inputSlider.value;
  slideValue.textContent = value;
  slideValue.style.left = value + "%";
  slideValue.classList.add("show");
};

inputSlider.onblur = () => {
  slideValue.classList.remove("show");
};

$(".booknow").on("click", function () {
  "use strict";

  var cookies = document.cookie.split(";");

  var d = new Date();

  for (var i = 0; i < cookies.length; i++) {
    var cookie = cookies[i];

    var eqPos = cookie.indexOf("=");

    var name = eqPos > -1 ? cookie.substr(0, eqPos) : cookie;

    document.cookie = name + "=; Path=/; Expires=" + d + ";";
  }
});

// sweetalert script for logout

function logout() {
  "use strict";

  Swal.fire({
    title: "Are You Sure to Logout?",

    showDenyButton: false,

    showCancelButton: true,

    confirmButtonText: "Yes"
  }).then(result => {
    if (result.isConfirmed) {
      Swal.fire("Saved!", "", "success");
    }
  });
}

function statusupdate(nexturl) {
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
      reverseButtons: true,
      showLoaderOnConfirm: true,
      preConfirm: function () {
        return new Promise(function (resolve, reject) {
          location.href = nexturl;
        });
      }
    })
    .then(result => {
      if (!result.isConfirmed) {
        result.dismiss === Swal.DismissReason.cancel;
      }
    });
}

// new design js //

$("#services-view").owlCarousel({
  loop: true,
  margin: 0,
  nav: true,
  dots: false,
  autoplay: false,
  // autoplayTimeout: 3000,
  navText: [
    "<i class='fa-solid fa-arrow-left-long'></i>",
    "<i class='fa-solid fa-arrow-right-long'></i>"
  ],
  responsive: {
    0: {
      items: 1
    },
    600: {
      items: 2
    },
    1000: {
      items: 3
    }
  }
});

$(".footer-fiechar-slider").owlCarousel({
  loop: true,
  margin: 10,
  nav: true,
  navText: [
    "<i class='fa-solid fa-arrow-left-long'></i>",
    "<i class='fa-solid fa-arrow-right-long'></i>"
  ],
  dots: false,
  responsive: {
    0: {
      items: 1
    },
    600: {
      items: 1
    },
    768: {
      items: 2
    },
    991: {
      items: 2
    }
  }
});

$("#carouselExampleSlides1").owlCarousel({
  loop: false,
  margin: 10,
  nav: true,
  autoHeight: true,
  navText: [
    "<i class='fa-solid fa-arrow-left-long'></i>",
    "<i class='fa-solid fa-arrow-right-long'></i>"
  ],
  dots: false,
  responsive: {
    0: {
      items: 1
    },
    600: {
      items: 1
    },
    1000: {
      items: 1
    }
  }
});

//====== img zoom GLightbox ======//
const lightbox = GLightbox({
  touchNavigation: true,
  loop: true,
  width: "90vw",
  height: "90vh"
});
$(".mobile-number").on("keyup", function () {
  "use strict";
  var val = $(this).val();
  if (isNaN(val)) {
    val = val.replace(/[^0-9\.+.-]/g, "");
    if (val.split(".").length > 2) {
      val = val.replace(/\.+$/, "");
    }
  }
  $(this).val(val);
});

function managefavorite(service_id, vendor_id, f_url) {
  "use Strict";
  if (is_logedin == 2) {
    location.href = loginurl;
  } else {
    $.ajax({
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
      },
      url: f_url,
      type: "post",
      dataType: "json",
      data: {
        service_id: service_id,
        vendor_id: vendor_id
      },
      success: function (response) {
        $("#preload").hide();
        if (response.status == 0) {
          toastr.error(response.message);
        } else {
          location.reload();
        }
      }
    });
  }
}

// ===================================== //

// PWA JS //
$("#close-btn").click(function () {
  $(".pwa-install").addClass("d-none");
});

let deferredPrompt = null;
window.addEventListener("beforeinstallprompt", e => {
  $(".mobile_drop_down").show();
  deferredPrompt = e;
});

if (window.matchMedia("(display-mode: standalone)").matches) {
  // If the app is installed, hide the install button or popup
  $(".pwa-install").addClass("d-none");
} else {
  const mobile_install_app = document.getElementById("mobile-install-app");
  if (mobile_install_app != null) {
    mobile_install_app.addEventListener("click", async () => {
      if (deferredPrompt !== null) {
        deferredPrompt.prompt();
        const { outcome } = await deferredPrompt.userChoice;
        if (outcome === "accepted") {
          deferredPrompt = null;
        }
      }
    });
  }
}
//PWA modal show
$(window).on("load", function () {
  $("#subsciptionmodal").modal("show");
  setTimeout(function () {
    $(".mobile_drop_down").animate(
      {
        bottom: "0px"
      },
      200
    );
  }, 1000);
});

// =============== Extra js add Dhruvil ======================== //

// Need Help button
const button = document.getElementById("quick-btn");
button.addEventListener("click", function () {
  this.classList.toggle("expanded");
});

$(document).ready(function () {
  // Function to add blur class to wrapper when modal has 'show' class
  function addBlurOnModalShow() {
    if ($(".modal").hasClass("show")) {
      $("#main-content").addClass("blur");
    }
  }
  // Call the function on document ready
  addBlurOnModalShow();
  // Event listener for modal visibility changes
  $(".modal").on("shown.bs.modal", function () {
    $("#main-content").addClass("blur");
  });
  $(".modal").on("hidden.bs.modal", function () {
    $("#main-content").removeClass("blur");
  });
});

$("#close-btn2").click(function () {
  $(".view-cart-bar-2").addClass("d-none");
});

function setLightMode() {
  document.documentElement.classList.remove('dark');
  document.documentElement.classList.add('light');
  localStorage.setItem('theme', 'light');
  $('#logoimage').attr('src', lightlogo);
  $('#footerlogoimage').attr('src', darklogo);
}

function setDarkMode() {
  document.documentElement.classList.remove('light');
  document.documentElement.classList.add('dark');
  localStorage.setItem('theme', 'dark');
  $('#logoimage').attr('src', darklogo);
  $('#footerlogoimage').attr('src', lightlogo);
}

