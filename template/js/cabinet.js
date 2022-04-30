$(".editPersonalData").click(function(e) {
    e.preventDefault();
    e.stopPropagation();
    $(".personalDataModal").fadeToggle();
 })

$('.btn-dropDown__phone').click(function (e) {
    e.preventDefault();
    $('.header__box_dropdown').slideToggle();
});

$('.btn-burger').click(function () {
    $('.overlay').fadeIn();
    $('.mobile-menu').fadeIn();
});

$('.mobile-menu .btn-close__menu').click(function () {
    $('.mobile-menu').fadeOut();
    $('.overlay').fadeOut();
});

$('.btn__mobile_catalog').click(function (e) {
    e.preventDefault();
    $('.overlay').fadeIn();
    $('.header__bottom').fadeIn();
});

$('.header__bottom .btn-close__menu').click(function () {
    $('.header__bottom').fadeOut();
    $('.overlay').fadeOut();
});

$('.menu__fixed_search').click(function (e) {
    e.preventDefault();
    $('.form-search__mobile').fadeToggle();
});

$('.btn_filter').click(function (e) {
    e.preventDefault();
    $('body, html').addClass('fixed-menu')
    $('.overlay').fadeIn();
    $('.sidebar').fadeIn();
});

$('.sidebar .btn-close__menu').click(function (e) {
    e.preventDefault();
    $('body, html').removeClass('fixed-menu');
    $('.sidebar').fadeOut();
    $('.overlay').fadeOut();
});

$('.btn_sort').click(function (e) {
    e.preventDefault();
    $('.overlay').fadeIn();
    $('.sorting-wrapper').fadeIn();
});

$('.sorting-wrapper .btn-close__menu').click(function (e) {
    e.preventDefault();
    $('.sorting-wrapper').fadeOut();
    $('.overlay').fadeOut();
});

$('.btn-menu__cabinet').click(function () {
    $('.overlay').fadeIn();
    $('.cabinet-sidebar').fadeIn();
});

$('.cabinet-sidebar .btn-close__menu').click(function () {
    $('.cabinet-sidebar').fadeOut();
    $('.overlay').fadeOut();
});

$('.cabinet-sidebar li a').each(function () {
    var location = window.location.href;
    var link = this.href;
    if (location == link) {
        $(this).addClass('active');
    }
});

$('input[type="file"]').change(function(){
    var value = $("input[type='file']").val();
    $('.js-value').text(value);
});



$('[name=phone]').mask('+7 (999) 999-99-99');
/*$("[name=phone]").inputmask({
    "mask": "+7 (999) 999-99-99"
  });*/

$('ul.tabs__caption').on('click', 'li:not(.active)', function () {
    $(this)
        .addClass('active').siblings().removeClass('active')
        .closest('div.tabs').find('div.tabs__content').removeClass('active').eq($(this).index()).addClass('active');
});

$('.filter__box_header').click(function () {
    $(this).parents('.filter__box').toggleClass('open');
});

// модальные окна
$(document).ready(function () {
    var overlay = $('.overlay');
    var open_modal = $('.open_modal');
    var close = $('.modal__close, .overlay');
    var modal = $('.modal__div');

    open_modal.click(function (event) {
        event.preventDefault();
        var div = $(this).attr('href');
        overlay.fadeIn(400,
            function () {
                $(div)
                    .css('display', 'flex')
                    .animate({
                        opacity: 1,
                        top: '50%'
                    }, 200);
            });
    });

    close.click(function () {
        modal
            .animate({
                    opacity: 0,
                    top: '45%'
                }, 200,
                function () {
                    $(this).css('display', 'none');
                    overlay.fadeOut(400);
                }
            );
    });
});
//end


$(document).on('click', '.up', function (e) {
    e.preventDefault();
    var a = $(this).data("order"),
        i = $(this).parent(),
        t = $(i).find("input"),
        n = t.val();
        if (void 0 !== a && "" != a && 1 != a) {
            var o = 1 * n + 1 * a;
            t.val(o)
        } else t.val(++n)
    }), $(document).on('click', '.down', function (e) {
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

// fixed block cabinet
$(function(){
	$nav = $('.blockCat');
	// $nav.css('width', $nav.outerWidth());
	$window = $(window);
	$h = $nav.offset().top;
	$window.scroll(function(){
		if ($window.scrollTop() > $h) {
			$nav.addClass('fixed-blockCat');
		} else {
			$nav.removeClass('fixed-blockCat');
		}
	});
});
