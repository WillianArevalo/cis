$(document).ready(function () {
  var selectedTheme = localStorage.getItem("theme");
  var themeButton = $(".button-theme");
  if (selectedTheme) {
    $("body").addClass(selectedTheme);
    themeButton.removeClass("active");
    $("#" + selectedTheme + "Button").addClass("active");
  } else {
    selectedTheme = "light";
    localStorage.setItem("theme", selectedTheme);
    $("body").addClass(selectedTheme);
    $("#lightButton").addClass("active");
  }

  themeButton.on("click", function () {
    var themeId = $(this).attr("id");
    if (themeId === "lightButton") {
      selectedTheme = "light";
    } else if (themeId === "darkButton") {
      selectedTheme = "dark";
    }
    localStorage.setItem("theme", selectedTheme);
    $("body").removeClass("light dark").addClass(selectedTheme);
    themeButton.removeClass("active");
    $(this).addClass("active");
  });
});
