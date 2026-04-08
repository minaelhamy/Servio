// OG Image Image Preview JS
$("#og_imageupload")
  .on("change", function() {
    "use strict";
    $("#og_imagepreview").hide();
    $("#og_image_show").show();
    if (this.files && this.files[0]) {
      var reader = new FileReader();
      $("#og_image_show").hide();
      reader.onload = function(e) {
        document.getElementById("og_image_imgupload").src = e.target.result;
        $("#og_imagepreview").fadeIn(650);
      };
      reader.readAsDataURL(this.files[0]);
    }
  })
  .change();
