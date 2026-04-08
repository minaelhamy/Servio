$(document).ready(function() {
  "use strict";
  /*  APPOINTMENTS CALENDER  */
  if (document.getElementById("sl-calendar")) {
    jQuery("#sl-calendar").fullCalendar({
      height: "auto",
      dayRender: function(date, cell) {
        // It's an example, do your own test here
        if (cell.hasClass("fc-past")) {
          cell.addClass("disabled");
        }
      },
      dayClick: function(date, jsEvent, view) {
        $("#sl-calendar")
          .find(".fc-state-highlight")
          .removeClass("fc-today fc-state-highlight text-white");
        var selected_date = moment(date).format("YYYY-MM-DD");
        var newdate = new Date();
        var current_date = moment(newdate).format("YYYY-MM-DD");
        if (selected_date < current_date) {
          return false;
        }
        $("#date_select_msg").hide();
        $("#timelist").removeClass(
          "d-flex align-items-center justify-content-center"
        );

        $("#sl-calendar")
          .find("[data-date='" + selected_date + "']")
          .addClass("fc-today fc-state-highlight text-white");

        $("#selecteddate").val(selected_date);
        callajaxtimeslot(selected_date);
      }
    });
    $("#sl-calendar")
    .find(".fc-state-highlight")
    .removeClass("fc-today fc-state-highlight text-white");

    $(".sl-appointmentPopup").on("shown.bs.modal", function() {
      $("#sl-calendar").fullCalendar("render");
    });
    
  }
  if (sessiondate != null && sessiondate != "") {
    $("#date_select_msg").hide();
    callajaxtimeslot(sessiondate);
  }
  $("#timelist").addClass(
    "d-flex align-items-center justify-content-center"
  );
  checkyearmonth();
  $(".staff_member").html(getCookie("staff"));
});

$("body").on("click", "button.fc-prev-button", function() {
  "use strict";
  checkyearmonth();
});
$("body").on("click", "button.fc-next-button", function() {
  "use strict";

  checkyearmonth();
});
function checkyearmonth() {
  "use strict";
  const date = new Date();
  const monthNames = [
    "January",
    "February",
    "March",
    "April",
    "May",
    "June",
    "July",
    "August",
    "September",
    "October",
    "November",
    "December"
  ];
  const calandertext = $(".fc-left h2").html();
  if (
    date.getFullYear() == calandertext.split(" ")[1] &&
    monthNames[date.getMonth()] == calandertext.split(" ")[0]
  ) {
    $(".fc-prev-button").attr("disabled", true);
  } else {
    $(".fc-prev-button").attr("disabled", false);
  }
}

function onloadtimslots(selected_date, current_date) {
  "use strict";
  var set_date = selected_date;
  if (set_date == "" || set_date == null || selected_date < current_date) {
    set_date = current_date;
  }
  callajaxtimeslot(set_date);
}
function callajaxtimeslot(set_date) {
  
  ("use strict");
  $("#timelist").addClass(
    "d-flex align-items-center justify-content-center"
  );
  $("#timeslote")
    .show()
    .addClass("justify-content-center align-items-center")
    .html(
      '<div class="text-center" id="timeslote"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>'
    );
  $("#sl-calendar")
    .find(".fc-state-highlight")
    .removeClass("fc-today fc-state-highlight text-white");
  $("#sl-calendar")
    .find("[data-date='" + set_date + "']")
    .addClass("fc-today fc-state-highlight text-white");
  $.ajax({
    headers: {
      "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
    },
    url: $("#timesloturl").val(),
    type: "post",
    dataType: "json",
    data: {
      inputDate: set_date,
      vendor_id: $("#vendor_id").val(),
      service_id: $("#service_id").val(),
    },
    success: function(response) {
      let html = "";
      if (response == "1") {
        html +=
          '<label class="text-danger"><h5>' + store_close + "</h5><label>";
        $("#timelist").addClass(
          "d-flex align-items-center justify-content-center"
        );
        $("#close").show().html(html);
        $("#timeslote").hide();
      } else {
        $("#timelist").removeClass(
          "d-flex align-items-center justify-content-center"
        );
        for (var i in response) {
          var status = "lable-disable ";
          var disable = "disabled";
          if (response[i]["status"] === "active") {
            status = "lable-active";
            disable = "";
          }
          var default_time = "";
          var time_checked = "";
          if (set_date == sessiondate && sessiontime == response[i]["slot"]) {
            default_time = "active-time";
            time_checked = "checked";
          }
          html +=
            '<div class="col-6 d-flex"><span class="sl-radio next-step w-100"><input type="radio" name="time" onclick="selecttimeslot(this);" value="' +
            response[i]["slot"] +
            '" ' +
            time_checked +
            ' id="flexRadioDefault' +
            i +
            '" ' +
            disable +
            '><label for="flexRadioDefault' +
            i +
            '"class=" text-center w-100 ' +
            status +
            " " +
            default_time +
            '">' +
            response[i]["slot"] +
            "</label></span></div>";
        }
        $("#timeslote").show().html(html);
        $("#close").hide();
        // setdatecookie(set_date);
      }
    }
  });
}
function selecttimeslot(x) {
  "use strict";
  $(".active-time").removeClass("active-time");
  $(x).next().addClass("active-time");
  $(".date_time_error").html("");

  $("#selectedtime").val($(x).val());
  checkbooking($("#selecteddate").val(), $(x).val());
}
function checkbooking(date, time) {
 
  $.ajax({
    headers: {
      "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
    },
    url: slotlimiturl,
    type: "post",
    dataType: "json",
    data: {
      service_id: $("#service_id").val(),
      inputdate: date,
      time: time,
      vendor_id: $("#vendor_id").val()
    },
    success: function(response) {
      if (response == "0") {
        $('#cnext_button').attr("disabled", true);
        toastr.error(bookingmessage);
      } else {
        $('#cnext_button').removeAttr("disabled");
        location.href = nextpageurl + "?selecteddate=" + $("#selecteddate").val() + "&selectedtime=" + time +"&staff=" + $("#staff option:selected").val();
      }
    }
  });
}
$('#cnext_button').on('click',function(){
  "use strict";
     if($("#selectedtime").val() == "" || $("#selectedtime").val() == null)
     {
          toastr.error(validatetime);
          return false;
     } 
  });
 

