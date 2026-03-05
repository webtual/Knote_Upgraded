$(document).ready(function() {
  $(window).scroll(function() {
    if ($(document).scrollTop() > 5) {
      $(".sticky-navbar").addClass("stickynav");
    } else {
      $(".sticky-navbar").removeClass("stickynav");
    }
  });
});
$(document).ready(function(){
  $(".cunavbar-toggler").click(function(){
    $(".cucollapse").toggleClass("active");
    $(".cucollapse-overlay").toggleClass("active");
  });
});
$(document).ready(function(){
  $(".cucollapse-overlay").click(function(){
    $(".cucollapse").removeClass("active");
    $(".cucollapse-overlay").removeClass("active");
  });
});

