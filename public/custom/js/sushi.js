$(document).ready(function () {
  $('.sushi__categories').owlCarousel({
    loop:true,
    margin:10,
    items:3,
    dots: false,
    nav: true,
    navText:[
      "<img src='img/items/left.svg' alt=''>",
      "<img src='img/items/right.svg' alt=''>"
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
  })

});