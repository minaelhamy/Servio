$(window).on("load", function () {
  "use strict";

  if ($(".multimenu").find(".active")) {
    $(".multimenu").find(".active").parent().parent().addClass("show");

    $(".multimenu")
      .find(".active")
      .parent()
      .parent()
      .parent()
      .attr("aria-expanded", true);
  }
});
var tooltipTriggerList = [].slice.call(
  document.querySelectorAll('[data-bs-toggle="tooltip"]')
);

var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
  "use strict";

  return new bootstrap.Tooltip(tooltipTriggerEl);
});

function myFunction() {
  "use strict";

  toastr.error("This operation was not performed due to demo mode");
}

$(document).ready(function () {
  "use strict";

  $(".zero-configuration").DataTable({
    dom: "lBfrtip",
    lengthMenu: [[10, 25, 50, 100, 500, -1], [10, 25, 50, 100, 500, "All"]],
    buttons: [{ extend: "excelHtml5" }]
  });
});
$(function () {
  $("#tabledetails").sortable({
    items: "tr",
    cursor: "move",
    opacity: 0.6,
    update: function () {
      sendOrderToServer();
    }
  });

  function sendOrderToServer() {
    var order = [];
    $("tr.row1").each(function (index, element) {
      order.push({
        id: $(this).attr("data-id"),
        position: index + 1
      });
    });

    $.ajax({
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
      },
      type: "POST",
      dataType: "json",
      url: $("#tabledetails").attr("data-url"),
      data: {
        order: order
      },
      success: function (response) {
        if (response.status == 1) {
          toastr.success(response.msg);
        } else {
          console.log(response);
        }
      }
    });
  }
});

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

      reverseButtons: true
    })
    .then(result => {
      if (result.isConfirmed) {
        location.href = nexturl;
      } else {
        result.dismiss === Swal.DismissReason.cancel;
      }
    });
}

$(document).ready(function () {
  $(".numbers_only").keypress(function (e) {
    "use strict";
    var charCode = e.which ? e.which : event.keyCode;

    if (String.fromCharCode(charCode).match(/[^0-9]/g)) return false;
  });
});

//  numeric value validation

$(".numbers_decimal").on("keyup", function () {
  "use strict";

  var val = $(this).val();

  if (isNaN(val)) {
    val = val.replace(/[^0-9\.]/g, "");

    if (val.split(".").length > 2) {
      val = val.replace(/\.+$/, "");
    }
  }

  $(this).val(val);
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

document.addEventListener("DOMContentLoaded", function () {
  // Get references to the off-canvas and modal elements
  var offCanvas = document.getElementById("offCanvas");
  var modal = document.getElementById("orderButton");

  // Get references to the open buttons
  var openOffCanvasBtn = document.getElementById("openOffCanvas");
  var openModalBtn = document.getElementById("order");

  // Function to open off-canvas menu
  function openOffCanvas() {
    var offCanvasInstance = new bootstrap.Offcanvas(offCanvas);
    offCanvasInstance.show();
  }

  // Function to open modal
  function openModal() {
    var modalInstance = new bootstrap.Modal(modal);
    modalInstance.show();
  }

  // Event listener for open off-canvas button
  openOffCanvasBtn.addEventListener("click", openOffCanvas);

  // Event listener for open modal button
  openModalBtn.addEventListener("click", openModal);
});

// var header = document.getElementById("myDIV");
// var btns = header.getElementsByClassName("sidebr-box");
// for (var i = 0; i < btns.length; i++) {
//     btns[i].addEventListener("click", function () {
//         var current = document.getElementsByClassName("actives");
//         current[0].className = current[0].className.replace(" actives", "");
//         this.className += " actives";
//     });
// }


$("#close-btn2").click(function () {
  $(".notice_card").addClass("d-none");
});

$("#close-btn3").click(function () {
  $(".notice_card").addClass("d-none");
});


function setLightMode() {
  document.documentElement.classList.remove('dark');
  document.documentElement.classList.add('light');
  localStorage.setItem('theme', 'light');
}

function setDarkMode() {
  document.documentElement.classList.remove('light');
  document.documentElement.classList.add('dark');
  localStorage.setItem('theme', 'dark');
}

//bulk_delete
  $('#selectAll').on('change', function () {
    $('.row-checkbox').prop('checked', $(this).prop('checked'));
    toggleDeleteButton();
  });

//  Delete Button based on individual selection
  $('.row-checkbox').on('change', function () {
    toggleDeleteButton();
  // Uncheck "Select All" if any is unchecked
        if (!$(this).prop('checked')) {
            $('#selectAll').prop('checked', false);
        }
    });

    function toggleDeleteButton() {
        let anyChecked = $('.row-checkbox:checked').length > 0;
        $('#bulkDeleteBtn').toggleClass('d-none', !anyChecked);
    }

  //   // Bulk Delete Handler
  // function deleteSelected(statusurl) {
  //   alert(statusurl);
  //   let id = $('.row-checkbox:checked').map(function () {
  //     return $(this).val();
  //   }).get();
  //   "use strict";
  //   if (env == "sandbox") {
  //     if (!nexturl.includes("orders") && !nexturl.includes("logout")) {
  //       myFunction();
  //       return false;
  //     }
  //   }
  //   const swalWithBootstrapButtons = Swal.mixin({
  //     customClass: {
  //       confirmButton: "btn btn-success mx-1",
  //       cancelButton: "btn btn-danger mx-1"
  //     },
  //     buttonsStyling: false
  //   });
  //   swalWithBootstrapButtons
  //   .fire({
  //     title: are_you_sure,
  //     icon: "warning",
  //     showCancelButton: true,
  //     confirmButtonText: yes,
  //     cancelButtonText: no,
  //     reverseButtons: true
  //   })
  //   .then(result => {
  //     if (result.isConfirmed) {

  //       $.ajax({
  //         headers: {
  //           "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
  //           },
  //           url: statusurl,
  //           data: {
  //           id: id,
  //           },
  //           method: "GET",
  //           success: function (response) {
  //             console.log(response);
  //             $("#preload").hide();

  //             if (response.status == 0) {
  //               toastr.error(response.msg);
  //             } else {
  //               sessionStorage.setItem("successMessage", response.msg);
  //               location.reload();
  //             }
  //           }
  //       });
       
  //     } else {
  //       result.dismiss === Swal.DismissReason.cancel;
  //     }
  //   });
  // }
  //  document.addEventListener("DOMContentLoaded", function () {
  //   const successMessage = sessionStorage.getItem("successMessage");
  //   if (successMessage) {
  //     toastr.success(successMessage);
  //     sessionStorage.removeItem("successMessage");
  //   }
  // });

  function deleteSelected(nexturl) {
    let id = $('.row-checkbox:checked').map(function () {
      return $(this).val();
    }).get();
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

      reverseButtons: true
    })
    .then(result => {

      if (result.isConfirmed) {
        $.ajax({
          headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            url: nexturl,
            data: {
            id: id,
            },
            method: "GET",
            success: function (response) {
              console.log(response);
              $("#preload").hide();

              if (response.status == 0) {
                toastr.error(response.msg);
              } else {
                sessionStorage.setItem("successMessage", response.msg);
                location.reload();
              }
            }
        });
      } else {
        result.dismiss === Swal.DismissReason.cancel;
      }
    });
  }

   document.addEventListener("DOMContentLoaded", function () {
    const successMessage = sessionStorage.getItem("successMessage");
    if (successMessage) {
      toastr.success(successMessage);
      sessionStorage.removeItem("successMessage");
    }
  });
