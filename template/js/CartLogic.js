// Отображение рассчётных данных по корзине
function display_cart_info(d) {

    // Выводим сумму для доставки
    $('.nextStep').html(d.nextSum);

    if (d.nextSum == null) {
        $('.nextStep').css('display', 'none');

    } else {
        $('.nextStep').css('display', 'flex');
    }

    // Получаем скидку от общей суммы
    var loyaltDisc = d.TotalPriceLoyalty;

    // Если она существует то отобращаем ее в блоке скидки
    if (loyaltDisc) {

        $('.promo__code').css('display', 'none');
        $('.procent_discount').html(loyaltDisc.toFixed(2) + ' ₽');
        $('.total-desc').css('display', 'flex');

    }

    // Получаем итоговую сумму с учетом скидки
    var togsPrice = 0 + d.TotalPrice;

    // Получаем сумму до применения скидки
    var allDiscount = parseFloat(loyaltDisc) + parseFloat(togsPrice);
    if (loyaltDisc > 0) {
        // Отображаем общую сумму в header
        if (isNaN(d.FinalPrice.toFixed(2))) {
            $(".basket-sum").html(0 + ' ₽');
        }
        else $(".basket-sum").html(allDiscount.toFixed(2) + ' ₽');
    } else {
        if (isNaN(d.FinalPrice.toFixed(2))) {
            $(".basket-sum, .basket__box_sum").html(0 + ' ₽');
        }
        else
            $(".basket-sum, .basket__box_sum").html(togsPrice.toFixed(2) + ' ₽');
    }


    // Выводим статус и скидку
    $('.okStatus').html(d.Status);
    $('.okP').html(d.Procent);

    // Выводим счетчик товаров в корзине
    $(".basket__val").html(d.Count);

    // Выводим стоимость доставки
    if (d.DeliveryCost > 0) {

        $('.cart_delivery').html(d.DeliveryCost.toFixed() + ' ₽');

    } else {

        $('.cart_delivery').html('бесплатно');
    }

    // Выводим итоговую сумму
    if (d.FinalPrice) {
        if (isNaN(d.FinalPrice.toFixed(2))) {
            $('.total-sum').html(0 + ' ₽');
        }
        else $('.total-sum').html(d.FinalPrice.toFixed(2) + ' ₽');

    }

    // В зависимости от возможности доставки, отображаем поля и предупреждение
    if (d.DeliveryAlert) {

        $('.btn_red, .btn_black, .input_coupon').addClass('block_count_cart');
        $('.input_coupon').attr('readonly', true);
        $('.shopping-basket__total_list').css('display', 'none');
        $('.shopping-basket__attention').css('display', 'flex');

    } else {

        // Выводим информацию о скидке    
        if (d.DiscountPrice > 0) {

            $('.procent_discount').html(d.DiscountPrice.toFixed(2) + '<span class="percent-sale color_red"> (' + d.CouponDiscount + '%)</span>');
            $('.procent_discount').css('display', 'flex');

            // случай если авторизован
        } else if (loyaltDisc) {

            $('.promo__code').css('display', 'none');
            $('.procent_discount').html(loyaltDisc.toFixed(2) + ' ₽');

            // иначе выводим в скидку 0
        } else {

            $('.procent_discount').html('0');
        }

        $('.btn_red, .btn_black, .input_coupon').removeClass('block_count_cart');
        $('.input_coupon').attr('readonly', false);
        $('.shopping-basket__total_list').css('display', 'block');
        $('.shopping-basket__attention').css('display', 'none');

    }

    // Выводим стоимость с учётом скидки для каждой позиции
    $('.table__body input').each(function() {

        var cost = d.products[$(this).data('id')].discount_cost;
        $(this).closest('.table-body_line').find('.cart_iteme_price').html(cost.toFixed(2));

    });

    return d.Count;

}

// Обновляем значения при загрузке страницы    
cart_show_ajax();

// Обработчик удаления товара из корзины            
$('.btn-delete').click(function(e) {
    var id = $(this).closest('.table-body_line').find('.count_item').attr('data-id');
    $(this).closest('.table-body_line').remove();
    $.post("/cart/delAjax/" + id, function(data) {
        if (data.Count) display_cart_info(data);
        else location.reload();
    }, 'json')
    timeout(location.reload(), 1000);
});

$('.inputCoupon').click(function(e) {
    e.preventDefault();
});
// Обработка данных при вводе купона (потеря фокуса)
$(".input_coupon").blur(function() {

    var coupons = $('.input_coupon').val();
    var coupon = coupons.replace(/ +/g, '');
    $('.input_coupon').val('');
    if (!coupon.length) return;

    // Регистриуем купон
    $.post("/cart/couponAjax", { coupon: coupon }, function(data) {

        // Проверяем результат прменения купона
        if (data.CouponDiscount > 0) {

            if (data.DiscountPrice > 0) {

                $('.total-desc').css('display', 'flex');
                $('.notification__promo').css('display', 'block');
                $('.notification__promo').css('background', 'green');
                setTimeout(function() {
                    $('.notification__promo').slideUp(500);
                }, 3000);
            } else {

                $('.notification__promo').css('display', 'block');
                $('.notification__promo').html('Только от ' + data.CouponAlert + ' ₽');
                $('.notification__promo').css('background', '#ff393c');
                setTimeout(function() {
                    $('.notification__promo').slideUp(500);
                }, 3000);
                $('.total-desc').css('display', 'none');
            }

        } else {

            $('.notification__promo').css('display', 'block');
            $('.notification__promo').html('Неверный купон');
            $('.notification__promo').css('background', '#ff393c');
            setTimeout(function() {
                $('.notification__promo').slideUp(500);
            }, 3000);
            $('.total-desc').css('display', 'none');
        }

        display_cart_info(data);

    }, 'json');
});

//  $("#phone").mask("+7 999 999 99 99", {placeholder: ""});

// Обработка данных при потере фокуса на количестве товара
$('.count_item').blur(function() {

    var id = $(this).closest('.basket__table_quantity').find('.count_item').attr("data-id");
    var count_product = $(this).closest('.basket__table_quantity').find('input[name=count_product]').val();
    cart_set_ajax(id, count_product);
    var countItemBlur = $(this).closest('.table-cart__body-line').find('.count_item').val();
    var priceOneBlur = parseFloat($(this).closest('.table-cart__body-line').find('.cart_iteme_price_one').text());
    var totalPriceBlur = countItemBlur * priceOneBlur;
    $(this).closest('.table-cart__body-line').find('.cart_iteme_price').html(totalPriceBlur.toFixed(2));

});

// Обработка данных при нажатии кнопки enter в поле количества
$('.count_item').keydown(function(e) {
    if (e.keyCode === 13) {
        e.stopPropagation();
        var id = $(this).closest('.basket__table_quantity').find('.count_item').attr("data-id");
        var count_product = $(this).closest('.basket__table_quantity').find('input[name=count_product]').val();
        cart_set_ajax(id, count_product);
        var countItemBlur = $(this).closest('.table-body_line').find('.count_item').val();
        var priceOneBlur = parseFloat($(this).closest('.table-body_line').find('.cart_iteme_price_one').text());
        var totalPriceBlur = countItemBlur * priceOneBlur;
        $(this).closest('.table-cart__body-line').find('.cart_iteme_price').html(totalPriceBlur.toFixed(2));
    }
});

$('input[name=count_product]').blur(function() {

    var renameVal = $(this).closest('.basket__table_quantity').find('input[name=count_product]').val();
    this.value = Math.abs(this.value.replace(/^0+/, ''));

    if (renameVal == 0) {
        $(this).closest('.basket__table_quantity').find('input[name=count_product]').val(1);
    }
});

$('.form-promo__code').keydown(function(event) {

    if (event.keyCode == 13) {

        event.preventDefault();
        return false;
    }

});

$('.cart_up').click(function() {

    var id = $(this).closest('.table-body_line').find('.count_item').attr("data-id");
    var count_product = $(this).data('order');
    cart_add_ajax(id, count_product, true);
});

$('.cart_down').click(function() {
    var id = $(this).closest('.table-body_line').find('.count_item').attr("data-id");
    var count_product = $(this).data('order');
    cart_add_ajax(id, -count_product, true);
});