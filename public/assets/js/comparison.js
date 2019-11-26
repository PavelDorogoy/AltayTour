
// Compare cards Read more
$('#btn-cards-more').click(function() {
    $('.compare-cards-more').slideToggle();
    $('.compare-cards').toggleClass("full");
    if ($(`#${this.id}`).text() == "Показать ещё") {
        $(this).text("Скрыть")
    } else {
        $(this).text("Показать ещё")
    }
});
(function($){
    $(window).on("load",function(){
      $(".table-compare").mCustomScrollbar({
        axis:"x",
        theme:"dark-3",
        mouseWheel: false,
        advanced:{ autoExpandHorizontalScroll:true }
      });
    });
  })(jQuery);