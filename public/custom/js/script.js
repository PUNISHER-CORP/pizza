// function testWebP(callback) {
//
// var webP = new Image();
// webP.onload = webP.onerror = function () {
// callback(webP.height == 2);
// };
// webP.src = "data:image/webp;base64,UklGRjoAAABXRUJQVlA4IC4AAACyAgCdASoCAAIALmk0mk0iIiIiIgBoSygABc6WWgAA/veff/0PP8bA//LwYAAA";
// }
//
// testWebP(function (support) {
//
// if (support == true) {
// document.querySelector('body').classList.add('webp');
// }
// });
// ;

$(document).ready(function () {
    $('.header__burger').click(function () {
        $('.header__burger, .header__menu').toggleClass('active');
        $('body').toggleClass('lock');
    });

    $('ul.menu__tabs').on('click', 'li:not(.active)', function() {
        $(this)
          .addClass('menu__tab-active').siblings().removeClass('menu__tab-active')
          .closest('.menu').find('div.menu__inner').removeClass('menu__inner-active').eq($(this).index()).addClass('menu__inner-active');
    });

    function counter(classes) {
        $(classes).each(function (i){
            let $product__card = $(this);
            $(this).on('click', '.button-plus', function (e) {
                let countField = parseInt($product__card.find('.count').val());
                $product__card.find('.count').val(countField + 1);
            });
            $(this).on('click', '.button-minus', function (e) {
                let countField = parseInt($product__card.find('.count').val());
                if (countField > 1) {
                    $product__card.find('.count').val(countField - 1);
                }
            });
        });
    }
    
    counter('.menu__inner .product__card');
    counter('.cart__container .cart__item');
    counter('.order__container .order__item');
    

    $(window).scroll(function() {
        if ($(document).scrollTop() > 100) {
            $('.header').css('background-color', 'rgba(39, 40, 44, 0.9)');
        }
        else {
            $('.header').css('background-color', 'unset');
        }
    });

    $('.header__item').click(function () {
        $('.header__menu').removeClass('active');
        $('.header__burger').removeClass('active');
    });

    $('.dropbtn').click(function () {
        $('.dropdown-content').toggle("slide");
    });


    $('.login__link').click(function () {
        $('.popup__login').addClass('popup__login-active');
        $('.popup').addClass('popup-active');
    });

    $('.cart__link').click(function () {
        $('.popup__cart').addClass('popup__cart-active');
        $('.popup').addClass('popup-active');
    });

    $('.popup__close').click(function () {
        $('.popup__login').removeClass('popup__login-active');
        $('.popup__register').removeClass('popup__register-active');
        $('.popup__cart').removeClass('popup__cart-active');
        $('.popup').removeClass('popup-active');
    });

    $('.popup__register-link').click(function () {
        $('.popup__login').removeClass('popup__login-active');
        $('.popup__register').addClass('popup__register-active');
    });

    $('.popup__login-link').click(function () {
        $('.popup__login').addClass('popup__login-active');
        $('.popup__register').removeClass('popup__register-active');
    });
});
