$(document).ready(function () {
  $('.sushi__categories').owlCarousel({
    margin:10,
    items:2,
    dots: false,
    nav: true,
    navText:[
      "<i class=\"fas fa-arrow-left\"></i>",
      "<i class=\"fas fa-arrow-right\"></i>"
    ],
    responsive : {
      // breakpoint from 0 up
      0 : {
        items:1,
        margin:0,
      },
      // breakpoint from 480 up
      480 : {
        items:2,
        margin:0,
      },
      // breakpoint from 768 up
      768 : {
        items:2,
        margin:0,
      },

      1200 : {
        items:3,
        margin:0,
      },

      1500 : {
        items:4,
      }
    }
  });
});

var li =  $(".sushi__categories li ");
$(".sushi__categories li").click(function(){
  $('.sushi__category').removeClass('active');
  $(this).addClass('active');
});
