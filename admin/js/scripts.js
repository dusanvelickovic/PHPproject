$(document).ready(function () {
  $("#summernote").summernote({
    height: 200,
  });
});

$(document).ready(function () {
  $("#selectAllBoxes").click(function (event) {
    if (this.checked) {
      $(".checkBoxes").each(function () {
        this.checked = true;
      });
    } else {
      $(".checkBoxes").each(function () {
        this.checked = false;
      });
    }
  });

  let div_box = "<div id='load-screen'><div id='loading'></div></div>";

  $("body").prepend(div_box);
  $("#load-screen")
    .delay(0)
    .fadeOut(100, function () {
      $(this).remove();
    });
});

function loadUsersOnline() {
  $.get("functions.php?onlineusers=result", function (data) {
    $(".usersonline").text(data);
  });
}

setInterval(function () {
  loadUsersOnline();
}, 500);
