 function dropDownShow() {
               document.querySelector(".new-dropdown-menu-list").classList.toggle('show');
               document.querySelectorAll(`[data-aff_id = "ИНВЕНТАРЬ ДЛЯ УБОРКИ"]`).forEach(function(podcatlink) {
                     podcatlink.style.display = 'none';
                  });
            }
            let allFirstMenuItems = document.querySelectorAll(".menu-category__links");
            allFirstMenuItems.forEach(function(element) {
               element.addEventListener('mouseenter', function() {
                  document.querySelectorAll('.podcat-link').forEach(function(podcatLink) {
                     podcatLink.style.display = 'none';
                  })
                  let firstMenuItemName = element.innerText.toLowerCase();
                  document.querySelectorAll(`[data-aff_id = "${firstMenuItemName}"]`).forEach(function(podcatlink) {
                     podcatlink.style.display = 'block';
                  });
               })

            })
            
        
           document.addEventListener("click", (e) => {
            if (!e.target.className.includes('dropdown-T')) {
               document.querySelector(".new-dropdown-menu-list").classList.remove('show');
               }
});

$("#cabinet_icon").click(function(e){
    e.preventDefault();
    $('.mobile-menu').fadeOut();
    $('.overlay').fadeOut();
    $("#cabinet-menu-block").toggleClass("activeCabinetMenu");
    $(".close-button-cabinet-menu").click(function(e){
        e.preventDefault();
        $("#cabinet-menu-block").removeClass("activeCabinetMenu");
    })

})

$(".form-subscribe").submit(function(e) {
    e.preventDefault();
    var errors = '';
    var pattern = /^[А-Яа-яЁё]{2,}$/;
    var patternMail = /^[a-z0-9_\-.]+@[a-z0-9-]+\.[a-z]{2,6}$/i;
    var name = $('input[name=name]').val();
    var mail = $('input[name=mail]').val();
    var goodSubscribe = '<p class="ok_message">Вы подписаны! Ловите промокод на почте</p>';
    var badSubscribe = '<p class="error_message">Email уже подписан</p>';

    if (!pattern.test(name)) {
        errors += '<p class="error_message">Недопустимые символы в имени</p>';
        $('.subscribe_name').css('border', '2px solid #ff393c');
    } else { $('.subscribe_name').css('border', 'solid 1px rgba(0, 0, 0, 0.15)'); }

    if (!patternMail.test(mail)) {
        errors += '<p class="error_message">Недопустимые символы в EMAIL</p>';
        $('.subscribe_email').css('border', '2px solid #ff393c');
    } else { $('.subscribe_email').css('border', 'solid 1px rgba(0, 0, 0, 0.15)'); }

    if (errors == '') {
        var msg = $('.form-subscribe').serialize();
        $.ajax({
            type: "POST",
            url: "/components/ajaxRequest/subscribeFile.php",
            data: msg,
            dataType: 'json',
            success: function(data) {
                if (data.result == 'success') {
                    console.log(data);
                    $('.form-subscribe').find('input[name=mail]').val('');
                    $('.form-subscribe').find('input[name=name]').val('');
                    $('#signup-response').html(goodSubscribe);
                    $('#signup-response').css('display', 'flex');
                } else {
                    console.log(data);
                    $('#signup-response').html(badSubscribe);
                    $('#signup-response').css('display', 'flex');
                    $('.subscribe_email').css('border', '2px solid #ff393c');
                }
            }
        });
        setTimeout(function() {
            $("#signup-response").fadeOut(1000);
        }, 5000);
    } else {
        $('#signup-response').html(errors);
        $('#signup-response').show();
        setTimeout(function() {
            $("#signup-response").fadeOut(1000);
        }, 5000);
    }
});


$('.main-home__slider').slick({
    slidesToShow: 1,
    dots: true,
    prevArrow: '<button type="button" class="slick-prev"></button>',
    nextArrow: '<button type="button" class="slick-next"></button>',
    fade: true,
    autoplay: true,
    autoplaySpeed: 3000,
    speed: 1200,
    fade: true,
    cssEase: 'linear'
});


$('.slider-nav').slick({
    autoplay: false,
    arrows: false,
    dots: false,
    slidesToShow: 3,
    draggable: true,
    swipe: false,
    touchMove: false,
    vertical: true,
    adaptiveHeight: true,
    focusOnSelect: true,
    asNavFor: '.product-section__image_slider_max',
});

$('.product-section__image_slider_max').slick({
    slidesToShow: 1,
    useTransform: true,
    arrows: false,
    dots: false,
    vertical:true

});

$('.manufacturers-slider').slick({
    rows:2,
    arrows: false,
    autoplay: true,
    useTransform: true,
    infinite: true,
    slidesToShow: 6,
	slidesToScroll: 1,
    responsive: [{
            breakpoint: 992,
            settings: {
                slidesPerRow: 3,
            }
        },
        {
            breakpoint: 575,
            settings: {
                slidesPerRow: 2,
            }
        },
        {
            breakpoint: 360,
            settings: {
                slidesPerRow: 1,
            }
        }
    ]

});

$('.arrow-down-main-page').click(function() {
    $('.box-text').toggleClass('box-text-show');
});

$('.product-gallery').fancybox();

$('.btn-dropDown__phone').click(function(e) {
    e.preventDefault();
    $('.header__box_dropdown').slideToggle();
});

$('.btn-burger').click(function() {
    $('.overlay').fadeIn();
    $("#cabinet-menu-block").removeClass("activeCabinetMenu");
    $('.mobile-menu').fadeIn();
});

$('.mobile-menu .btn-close__menu').click(function() {
    $('.mobile-menu').fadeOut();
    $('.overlay').fadeOut();
});

$('.btn__mobile_catalog').click(function(e) {
    e.preventDefault();
    $('.overlay').fadeIn();
    $('.header__bottom').fadeIn();
});

$('.header__bottom .btn-close__menu, .overlay').click(function() {
    $('.header__bottom').fadeOut();
    $('.overlay').fadeOut();
});

$('.menu__fixed_search').click(function(e) {
    e.preventDefault();
    $('.form-search__mobile').fadeToggle(200);
});

$('.btn_filter').click(function(e) {
    e.preventDefault();
    $('body, html').addClass('fixed-menu')
    $('.overlay').fadeIn();
    $('.sidebar').fadeIn();
});

$('.sidebar .btn-close__menu, .overlay').click(function(e) {
    e.preventDefault();
    $('body, html').removeClass('fixed-menu');
    $('.sidebar').fadeOut();
    $('.overlay').fadeOut();
});

$('.btn_sort').click(function(e) {
    e.preventDefault();
    $('.overlay').fadeIn();
    $('.sorting-wrapper').fadeIn();
});

$('.sorting-wrapper .btn-close__menu, .overlay').click(function(e) {
    e.preventDefault();
    $('.sorting-wrapper').fadeOut();
    $('.overlay').fadeOut();
});

$('.btn-menu__cabinet').click(function() {
    $('.overlay').fadeIn();
    $('.cabinet-sidebar').fadeIn();
});

$('.cabinet-sidebar .btn-close__menu, .overlay').click(function() {
    $('.cabinet-sidebar').fadeOut();
    $('.overlay').fadeOut();
});

$('.cabinet-sidebar li a').each(function() {
    var location = window.location.href;
    var link = this.href;
    if (location == link) {
        $(this).addClass('active');
    }
});

$('ul.tabs__caption').on('click', 'li:not(.active)', function() {
    $(this)
        .addClass('active').siblings().removeClass('active')
        .closest('div.tabs').find('div.tabs__content').removeClass('active').eq($(this).index()).addClass('active');
});


/*$("[name=phone]").on('click', function() {

    $.mask.definitions['h'] = "[9]";

    $(this).setCursorPosition(4);

    $("[name=phone]").mask("+7 (h99) 999-99-99", { autoclear: false });
})
$.mask.definitions['h'] = "[9]";
$('[name=phone]').mask('+7 (h99) 999-99-99');*/

$(document).ready(function() {
    var overlay = $('.overlay');
    var open_modal = $('.open_modal');
    var close = $('.modal__close, .overlay');
    var modal = $('.modal__div');

    open_modal.click(function(event) {
        event.preventDefault();
        var div = $(this).attr('href');
        overlay.fadeIn(400,
            function() {
                $(div)
                    .css('display', 'flex')
                    .animate({
                        opacity: 1,
                        top: '50%'
                    }, 200);
            });
    });

    close.click(function() {
        modal
            .animate({
                    opacity: 0,
                    top: '45%'
                }, 200,
                function() {
                    $(this).css('display', 'none');
                    overlay.fadeOut(400);
                }
            );
    });
});


$(document).on('click', '.price_one', function() {
    $('.price_pak').removeClass('active');
    $(this).addClass('active');
    var price_one = $(this).closest('.button__group').find('.price_one').data('price_one');
    let one_trimmed = price_one.trim();
    let strikeEl = $(this).closest('.product-card').find('strike');
    strikeEl.text('');
    $(this).closest('.product-card').find('.price span').html(price_one);
});

$(document).on('click', '.price_pak', function() {
    $('.price_one').removeClass('active');
    $(this).addClass('active');
    var price_pak = $(this).closest('.button__group').find('.price_pak').data('price_pak');
    let pak_trimmed = price_pak.trim();
    $(this).closest('.product-card').find('strike').text('');
    $(this).closest('.product-card').find('.price span').html(price_pak);
});

$(document).on('blur', 'input[name=count_product]', function() {
    var renameVal = $(this).closest('.product-box__info-bottom').find('input[name=count_product]').val();
    this.value = Math.abs(this.value.replace(/^0+/, ''));
    if (renameVal == 0) {
        $(this).closest('.product-box__info-bottom').find('input[name=count_product]').val(1);
    }
});

$(document).on('change keyup input click', 'input[name=count_product]', function() {
    if (this.value.match(/[^0-9]/g)) {
        this.value = this.value.replace(/[^0-9]/g, '');
    }
});

$(document).on('blur', 'input[name=count_product]', function() {
    var renameVal = $(this).closest('.product-card, .related-products__wrap, .product__quantity_box').find('input[name=count_product]').val();
    this.value = Math.abs(this.value.replace(/^0+/, ''));
    if (renameVal == 0) {
        $(this).closest('.product-card, .related-products__wrap, .product__quantity_box').find('input[name=count_product]').val(1);
    }
});

$(document).on('click', '.btn__add_card', function(e) {
    e.preventDefault();
    $(this).closest('.product-card').find('.btn__add_card, .amount').addClass('block_count_cart');
    $(this).closest('.product-card__body_bottom').find('.btn__add_card').html('В корзине');
    var count_productval = $(this).closest('.product-card').find('input[name=count_product]').val();
    var id = $(this).attr("data-id");
    cart_add_ajax(id, count_productval);
});

$(document).on('click', '.up', function(e) {
    e.preventDefault();
    var a = $(this).data("order"),
        i = $(this).parent(),
        t = $(i).find("input"),
        n = t.val();
    if (void 0 !== a && "" != a && 1 != a) {
        var o = 1 * n + 1 * a;
        t.val(o)
    } else t.val(++n)
}), $(document).on('click', '.down', function(e) {
    e.preventDefault();
    var a = $(this).parent(),
        i = $(this).data("order"),
        t = $(a).find("input"),
        n = t.val();
    if (void 0 !== i && "" != i && 1 != i) {
        var o = 1 * n - 1 * i;
        n > 1 * i && t.val(o)
    } else n > 1 && t.val(--n)
});


//
// Добавление товара в корзину или изменение количества для существующего товара
// После обновления отображает новые значения в корзине
//
function cart_add_ajax(id, count, reload = false) {
    let random = Math.floor(Math.random() * 1000);
    $.post("/cart/addAjax/" + id + '?x=' + random, { count: count }, function(data) {
        if (reload) { location.reload(); return; } else if (typeof(display_cart_info) == "function") {
            display_cart_info(data);
        } else {
            if (data) {
                $(".basket__val").html(data.Count);
                $(".basket__box_sum").html(data.TotalPrice + ' ₽');
            }
        }
    }, 'json');

}

//
// Добавление товара в корзину или устанавливаем количества для существующего товара
// После обновления отображает новые значения в корзине
//
function cart_set_ajax(id, count, reload = false) {
    $.post("/cart/setAjax/" + id, { count: count }, function(data) {
        if (reload) { location.reload(); return; } else if (typeof(display_cart_info) == "function") {
            display_cart_info(data);
        } else {
            if (data) {
                $(".basket__val").html(data.Count);
                $(".basket__box_sum").html(data.TotalPrice + ' ₽');
            }
        }
    }, 'json');
}

//
// Получает значения из корзины и отображает их
//
function cart_show_ajax(reload_if_empty = false) {
    $.post("/cart/addAjax/0", function(data) {
        if (typeof(display_cart_info) == "function") {
            var count = parseInt(display_cart_info(data));
            if (reload_if_empty && !count) { location.reload(); return; }
        } else {
            $(".basket__val").html(data.Count);
            if (data.TotalPrice) $(".basket__box_sum").html(data.TotalPrice);
            else $(".basket__box_sum").html('');
        }
    }, 'json');
}


$('.search, .search_mobile').keyup(function() {
    var searchVal = $('input[name="search"]').val();
    if (searchVal.trim().length > 2) {

        $.ajax({
            type: 'post',
            url: "/components/ajaxRequest/searchajax.php",
            data: {
                search: searchVal.trim()
            },
            dataType: 'TEXT',
            success: function(data) {
                $(".search__result").html(data).fadeIn(100);
            }
        })
    }
});

// аккордеон
$('.panel_heading .block_title').click(function() {
    $(this).toggleClass('in').next().slideToggle();
    $('.panel_heading .block_title').not(this).removeClass('in').next().slideUp();
});

$('[name=userNameOneClick]').bind("change keyup input click", function() { if (this.value.match(/[^а-яА-Я\s]/g)) { this.value = this.value.replace(/[^а-яА-Я\s]/g, ''); } });


if ((document.querySelector("#nearestDate") != null)) {
    const nearestDateFunction = () => {
        let nowDate = new Date();
        let nowTime = nowDate.getHours();
        const months = {
            0: 'января',
            1: 'февраля',
            2: 'марта',
            3: 'апреля',
            4: 'мая',
            5: 'июня',
            6: 'июля',
            7: 'августа',
            8: 'сентября',
            9: 'октября',
            10: 'ноября',
            11: 'декабря'
        }

        if ((nowDate.getDay() !== 0) && (nowDate.getDay() !== 6) && (nowDate.getDay() != 5)) {
            let tomorrow = new Date();
            tomorrow.setDate(new Date().getDate() + 1);
            let dayAfterTomorrow = new Date();
            dayAfterTomorrow.setDate(new Date().getDate() + 2);
            let tommorowDay = tomorrow.getDate();
            if (nowTime < 14) {
                document.querySelector("#nearestDate").innerText = `завтра, ` +
                    `${ tommorowDay }` +
                    ` ` + `${  months[tomorrow.getMonth()]}`;
            } else if (nowTime >= 14) {
                document.querySelector("#nearestDate").innerText = `послезавтра, ` + ` ${ dayAfterTomorrow.getDate() } ` +
                    ` ` + `${ months[dayAfterTomorrow.getMonth()] } `;
            };
        } else if (nowDate.getDay() == 6) {
            let Monday = new Date();
            Monday.setDate(new Date().getDate() + 2);
            let Tuesday = new Date();
            Tuesday.setDate(new Date().getDate() + 3);
            if (nowTime < 14) {
                document.querySelector("#nearestDate").innerText = `в понедельник, ` +
                    `${ Monday.getDate() }` +
                    ` ` + `${  months[Monday.getMonth()]}`;
            } else
            if (nowTime >= 14) {
                document.querySelector("#nearestDate").innerText = `во вторник, ` +
                    `${ Tuesday.getDate() }` +
                    ` ` + `${  months[Tuesday.getMonth()]}`;
            }
        } else if (nowDate.getDay() == 5) {
            if (nowTime < 14) {
                let Saturday = new Date();
                Saturday.setDate(new Date().getDate() + 1);
                document.querySelector("#nearestDate").innerText = `в Субботу, ` +
                    `${ Saturday.getDate() }` +
                    ` ` + `${  months[Saturday.getMonth()]}`;
            } else if (nowTime >= 14) {
                let Monday = new Date();
                Monday.setDate(new Date().getDate() + 3);
                document.querySelector("#nearestDate").innerText = `в Понедельник, ` +
                    `${ Monday.getDate() }` +
                    ` ` + `${  months[Monday.getMonth()]}`;
            }
        } else if (nowDate.getDay() == 0) {
            let Tuesday = new Date();
            Tuesday.setDate(new Date().getDate() + 2);
            document.querySelector("#nearestDate").innerText = `во вторник, ` +
                `${ Tuesday.getDate() }` +
                ` ` + `${  months[Tuesday.getMonth()]}`;
        }

    }

    setTimeout(nearestDateFunction(), 5000);
}