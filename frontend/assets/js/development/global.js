jQuery(document).ready(function ($) {
  let video;
  const modal = $(".modal");

  window._wq = window._wq || [];
  _wq.push({
    id: "86xc4t7z04",
    onHasData: function (video) {
      if (video.hasData()) {
        video.bind("timechange", function (t) {
          if (t >= 60) {
            var data = {
              action: "is_user_logged_in",
            };

            jQuery.post(localized.ajaxurl, data, function (res) {
              if (res == "no") {
                // user is not logged in, show login form here
                video.pause();
                modal.addClass("modal--showing");
              }
            });
          }
        });
      }
    },
  });

  $("form#login").on("submit", function (e) {
    e.preventDefault();
    //dsiable form whilesending data
    // $(this).attr('disabled', true)
    var formData = $("form#login").serialize();
    $.ajax({
      type: "POST",
      dataType: "json",
      url: localized.ajaxurl,
      data: {
        action: "ajax_login", //calls wp_ajax_nopriv_ajaxlogin
        form_data: formData,
      },
      success: function (data) {
        console.log(data.data.loggedin);
        $("form#login p.status").text(data.data.message);
        if (data.data.loggedin === true) {
          modal.removeClass("modal--showing");
          _wq.push({
            id: "86xc4t7z04",
            onReady: function (video) {
              video.play();
            },
          });
        }
      },
    });
  });
});
