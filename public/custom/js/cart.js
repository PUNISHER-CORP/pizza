$(document).ready(function() {
    $('.header__cart').on('click', function() {
        let productType = $(this).data('producttype');

        $.ajax({
            url: Routing.generate('show_cart'),
            type: "GET",
            data: {type: productType},
            success: function(html) {
                $('.popup__cart .popup__body').html(html);
            },
        });
    });

    $(document).on("click", ".add-to-cart", function() {
        let $button = $(this);
        let $cardItem = $button.closest('.menu__item');
        let productId = $button.data('id');
        let quantity = $cardItem.find('.quantity-field').val()
        let dimension = $cardItem.find('.menu__dimensions').find('.menu__dimension-active').find('.dimension__text');
        let dimensionId = $(dimension).attr('data-dimensionId');

        let url = Routing.generate('cart_add_product', {'productId': productId, 'quantity': quantity, 'dimensionId': dimensionId});
        loadingButton($button);
        $.ajax({
            url: url,
            type: "GET",
            success: function (data) {
                $('.cart__badge').addClass('cart__badge-active').text(data.quantity);
                normalButton($button);
                toastr.success('Product został dodany do koszyka')
            },
            error: function (request,status, error) {
                // toastr.error(Translator.trans('cart.productWasntAddedToCart'));
            }
        });
    });

    function loadingButton($button) {
        $button.prop("disabled", true);
        $button.html('<i class="fas fa-spinner fa-spin"></i>');
    }

    function normalButton($button) {
        $button.prop("disabled", false);
        $button.html('Do koszyka');
    }

    $('.menu__dimensions').on('click', '.menu__dimension:not(.menu__dimension-active)', function() {
        $(this).addClass('menu__dimension-active').siblings().removeClass('menu__dimension-active');

        $('.product__card .menu__dimension').each(function (i) {
            if($(this).hasClass('menu__dimension-active')){
                let dimension = $(this).find('.dimension__text');
                let data = dimension.attr('data-price');
                let $product = $(this).closest('.item__footer');
                $product.find('.price').text(data + ' zł');
            }
        });
    });

    $('.product__card .menu__dimension').each(function (i) {
        if($(this).hasClass('menu__dimension-active')){
            let dimension = $(this).find('.dimension__text');
            let data = dimension.attr('data-price');
            let $product = $(this).closest('.item__footer');
            $product.find('.price').text(data + ' zł');
        }
    });
});
