$(document).ready(function () {
    $('.popup__close').click(function () {
        $('.popup__gratitude').removeClass('popup__gratitude-active');
        $('.popup').removeClass('popup-active');
    });
});