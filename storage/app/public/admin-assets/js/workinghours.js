$(document).ready(function() {
    "use strict";
   
    if(time_format == 1)
    {
        $(".timepicker").timepicker({
            showMeridian: false,     
            use24hours: true,
            timeFormat: 'H:mm',
            
        });
    }else{
        $(".timepicker").timepicker();
    }
  });