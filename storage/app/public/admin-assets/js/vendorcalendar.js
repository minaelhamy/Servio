$('#booking_date').on('change', function() {
    "use strict";
    $('#booking_time').empty();
    $.ajax({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        },
        url: sloturl,
        type: "post",
        dataType: "json",
        data: {
            inputDate: $(this).val(),
            service_id : $('#service').find(':selected').val(),
        },
        success: function(response) {
            let html = "";
            if (response == "1") {
                $('#store_close').removeClass('d-none');
                $('#delivery_time').addClass('d-none');
            } else {
                $('#store_close').addClass('d-none');
                $('#delivery_time').removeClass('d-none');
                $('#booking_time').append('<option value="">' + select + '</option>');
                for (var i in response) {
                    $('#booking_time').append('<option value="' + response[i]["slot"] + '">' +
                        response[i]["slot"] + '</option>');
                }

            }
        }
    });
});
$('#registereduser').on('change', function() {
    "use strict";
    $('#customerlist').removeClass('d-none');
    $('#customers').val(0);
    $('#customer_name').prop('readonly', true);
    $('#customer_email').prop('readonly', true);
    $('#customer_mobile').prop('readonly', true);

});

$('#service').on('change', function() {
    "use strict";
   var html ='';
    $.ajax({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        },
        url: staffurl,
        type: "post",
        dataType: "json",
        data: {
            vendor_id: vendor_id,
            service_id : $('#service').find(':selected').val(),
        },
        success: function(response) {
            if(response.status == 1)
            {
                if (response.staff_assign == "1") {
                    $('#staff_id').removeClass('d-none');
                    html = '<div class="form-group"><label class="form-label">' + staff_member + '<span class="text-danger">'+
                                '* </span></label> <select class="form-select border" name="staff" id="staff">';
                    $.each(response.data,function(key,value){
                        html += '<option data-id="'+ value.id +'" value="'+ value.id +'" required>'+ value.name +'</option>';
                      });
                      html += '</select></div>'
                   $('#staff_id').html(html);
                } else {
                    $('#staff_id').addClass('d-none');
                    $('#staff_id').prop('required',false);
                }
            }
            
        }
    });
   

});
$('#newuser').on('change', function() {
    "use strict";
    $('#customerlist').addClass('d-none');
    $('#customer_name').prop('readonly', false);
    $('#customer_email').prop('readonly', false);
    $('#customer_mobile').prop('readonly', false);
    $("#customer_name").val("");
    $("#customer_email").val("");
    $("#customer_mobile").val("");
});
$("#customers").on('change', function() {
    "use strict";
    $.ajax({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        },
        url: customerurl,
        type: "post",
        dataType: "json",
        data: {
            vendor_id: $(this).val(),
        },
        success: function(response) {
            $("#customer_name").val(response.name);
            $("#customer_email").val(response.email);
            $("#customer_mobile").val(response.mobile);

        }
    });
});


