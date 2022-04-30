// Глобальные переменные для работы фильтров
var FilterOptions = Array({}, {});
var FilterScript = '/components/ajaxRequest/catmy.php';
var CategoryCode = '';
var CategorySlug = '';
var ProductsStartLoad = 16;
var ProductsAddLoad = 8;

$(function() {

    // Получаем slug категории из URL страницы
    var sPath = window.location.pathname;
    var tmp = sPath.substring(sPath.lastIndexOf('/') + 1).match(/^([A-Za-z\d\-]*)/);
    CategorySlug = tmp[0];

    // Получаем шаблоны для фильтров и удаляем содержимое в десктопной и мобильной версии
    for (var i = 0; i < 2; i++) {
        var content = $($('.filter-content')[i]);
        var box = $(content.find('.filter__box')[1]);
        var li = $(box.find('li')[0]);
        box.find('li').remove();
        content.find('.filter__box').not(':first').remove();

        FilterOptions[i].filter_box = box;
        FilterOptions[i].filter_item = li;
    }

    // Запрашиваем список фильтров для категории
    $.getJSON(attrfilter_mainstr('filter'), function(data) {

        // Сохраняем загруженные данные
        if (data.status == 'success') {
            CategoryCode = data.cid;

            // Сортируем фильтры по алфавиту
            data.filters.sort(function(a, b) {
                if (a.title > b.title) return 1;
                if (a.title < b.title) return -1;
                return 0;
            });
            // Выводим HTML-код фильтров
            data.filters.forEach(function(next) {
                attrfilter_filter_add(next);
            });


            $('.filter__box_header').click(function() {
                $(this).toggleClass('open').siblings('.filter__box_body').slideToggle();
            });


            data.min_price = Math.floor(parseFloat(data.min_price));
            data.max_price = Math.ceil(parseFloat(data.max_price));

            $("#buy_price").slider({
                range: true,
                animate: "fast",
                min: data.min_price, // минимальное значение цены
                max: data.max_price, // максимальное значение цены
                //step: 1, // шаг слайдера
                values: [data.min_price, data.max_price], // начальные значения - позиции ползунков на шкале
                change: attrfilter_update,
                //classes: {
                //        "ui-slider-handle": "ui-corner-all"
                //    },
                slide: function(event, ui) {
                    // Поле минимального значения
                    $('input[name="price_s"]').val(ui.values[0]);
                    // Поле максимального значения
                    $('input[name="price_f"]').val(ui.values[1]);
                }

            });
            $('input[name="price_s"]').val(data.min_price);
            $('input[name="price_f"]').val(data.max_price);

            $('.filter__box input').on('change', attrfilter_update);

        }

    });

    // Обработка нажатия на кнопку 'Применить'
    $('.btn_apply').click(function(e) {
        e.preventDefault();
        // Загружаем новое содержимое для списка товаров
        $.get(attrfilter_optstr('content', true), function(data) {
            // Заменяем список товаров
            $('.appendChild').html(data);
            // Установка обработчика на кнопку "Загрузить ещё"
            $('.load-more').click(attrfilter_filter_addload);
        });
    });

    // Обработка нажатия на кнопку 'сбросить фильтр'
    $('.links-grey').click(function(e) {
        e.stopPropagation();
        // Инициируем перезагрузку станицы
        location.reload();
    });

    // Установка обработчика на кнопку "Загрузить ещё"
    $('.load-more').on('click', attrfilter_filter_addload);

    // Установка обработчика кнопок изменения вида сортировки
    $('.links-tag').on('click', function(e) {
        e.preventDefault();
        $(".links-tag").removeClass("active");
        $(this).addClass("active");
        // Обновляем содержимое на страницу
        $.get(attrfilter_optstr('content', true), function(data) {
            // Заменяем список товаров
            $('.appendChild').html(data);
            // Установка обработчика на кнопку "Загрузить ещё"
            $('.load-more').click(attrfilter_filter_addload);
        });
    });


});

// Обновление фильров при изменении одного из значений
function attrfilter_update() {
    // Выполняем запрос на обновление фильтров	
    $.getJSON(attrfilter_optstr('filter', true), function(data) {
        // Обновляем значения фильтров
        if (data.status == 'success') {
            data.filters.forEach(function(next) {
                attrfilter_filter_change(next);
            });
        }
    });
}

// Формируем основную часть строки запроса, включающуб путь, команду и признак custom
function attrfilter_mainstr(cmd) {
    var path = FilterScript + '?cmd=' + cmd;
    path += '&cat_slug=' + encodeURIComponent(CategorySlug);
    path += $('.is_custom').length ? '&custom=1' : '';
    return path;
}

// Формируем строку опций для текущих выбранных значений фильтра
function attrfilter_optstr(cmd, reload) {
    var selected = Array();
    $('.filter-content input[type="checkbox"]:checked').each(function() {
        selected.push(this.name);
    });

    // Формируем строку запроса
    var optstr = attrfilter_mainstr(cmd);
    optstr += CategoryCode ? '&cid=' + CategoryCode : '';
    optstr += '&min_price=' + encodeURIComponent($('.filter-content:visible input[name="price_s"]').val());
    optstr += '&max_price=' + encodeURIComponent($('.filter-content:visible input[name="price_f"]').val());
    optstr += '&sorting=' + $('.sorting__box_links.active').data('sort');
    optstr += '&selected=' + selected.join(';')
    if (cmd == 'content') {
        optstr += '&begin=' + (reload ? 0 : $('.product-card').length);
        optstr += '&count=' + (reload ? ProductsStartLoad : ProductsAddLoad);
    }
    return optstr;
}

// Обновление значений для одного фильтра в видимом блоке
function attrfilter_filter_change(filter) {
    var class_disabled = 'disabled';

    filter.values.forEach(function(next) {
        var target = $('.filter-content:visible input[name="' + next.id + '"]').parent().find('.label');
        target.text(next.name + ' (' + next.count + ')');
        target.removeClass(class_disabled);
        if (next.count == 0) target.addClass(class_disabled);
    });
}

// Добавление одного фильтра на страницу
function attrfilter_filter_add(filter) {
    // Добавляем код фильтра в оба блока (для десктопной и мобильной версии)
    for (var i = 0; i < 2; i++) {
        var box = FilterOptions[i].filter_box.clone();
        box.find('.filter__box_title').text(filter.title);

        // Сортируем опции фильтра
        filter.values = filter.values.sort(function(a, b) {
            if (a.name == parseInt(a.name) && b.name == parseInt(b.name)) return (parseInt(a.name) > parseInt(b.name)) ? 1 : -1;
            else return (a.name > b.name) ? 1 : -1;
        });

        filter.values.forEach(function(next) {
            var li = FilterOptions[i].filter_item.clone();
            li.find('input').attr('name', next.id);
            li.find('.label').text(next.name + ' (' + next.count + ')');
            box.find('.list-checkbox').append(li.get(0));
        });
        var content = $($('.filter__box')[i]);
        content.append(box.get(0));
    }
}

// Обработчик кнопки "Загрузить ещё"
function attrfilter_filter_addload(e) {
    e.preventDefault();
    // Догружаем содержимое на страницу
    $.get(attrfilter_optstr('content', false), function(data) {
        // Удаляем старую кнопку "Загрузить ещё"
        $('.appendChild .row').remove();
        // Дополняем список товаров
        $('.appendChild').append(data);
        // Установка обработчика на новую кнопку "Загрузить ещё"
        $('.load-more').click(attrfilter_filter_addload);
    });
}