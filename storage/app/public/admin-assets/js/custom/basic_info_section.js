// Logo Image Preview JS
$("#profileupload")
  .on("change", function() {
    "use strict";
    $("#profilepreview").hide();
    $("#profile_show").show();
    if (this.files && this.files[0]) {
      var reader = new FileReader();
      $("#profile_show").hide();
      reader.onload = function(e) {
        document.getElementById("profile_imgupload").src = e.target.result;
        $("#profilepreview").fadeIn(650);
      };
      reader.readAsDataURL(this.files[0]);
    }
  })
  .change();

// Banner Image Preview JS
$("#bannerupload")
  .on("change", function() {
    "use strict";
    $("#bannerpreview").hide();
    $("#banner_show").show();
    if (this.files && this.files[0]) {
      var reader = new FileReader();
      $("#banner_show").hide();
      reader.onload = function(e) {
        document.getElementById("banner_imgupload").src = e.target.result;
        $("#bannerpreview").fadeIn(650);
      };
      reader.readAsDataURL(this.files[0]);
    }
  })
  .change();
