<ul class="cabinet-menu">
   <?php if(self::checkAdmin()==false){ ?>
   <li class="cabinet-menu__item"><a href="/admin/order" class="cabinet-menu__links" title="Заказы">Заказы</a></li>
   <li class="cabinet-menu__item"><a href="/admin/clients" class="cabinet-menu__links" title="Клиенты">Клиенты</a></li>
   <li class="cabinet-menu__item"><a href="/admin/allprofile" class="cabinet-menu__links" title="Профили">Профили</a></li>
   <li class="cabinet-menu__item"><a href="/admin/report" class="cabinet-menu__links" title="Отчеты">Отчеты</a></li>
   <li class="cabinet-menu__item"><a href="/admin/send" class="cabinet-menu__links" title="Реквизиты">Реквизиты</a></li>
   <li class="cabinet-menu__item"><a href="/admin/drop" class="cabinet-menu__links" title="Категории">Брошенные корзины</a></li>
   <?php } else { ?>
   <li class="cabinet-menu__item"><a href="/admin/order" class="cabinet-menu__links" title="Заказы">Заказы</a></li>
   <li class="cabinet-menu__item"><a href="/admin/hit" class="cabinet-menu__links" title="Хиты продаж">Хиты продаж</a></li>
   <li class="cabinet-menu__item"><a href="/admin/saleblock" class="cabinet-menu__links" title="Блок акций">Блок акций</a></li>
   <li class="cabinet-menu__item"><a href="/admin/banners" class="cabinet-menu__links" title="Баннеры">Баннеры</a></li>
   <li class="cabinet-menu__item"><a href="/admin/onlysales" class="cabinet-menu__links" title="Акции">Акции</a></li>
   <li class="cabinet-menu__item"><a href="/admin/allrules" class="cabinet-menu__links" title="Правила корзины">Правила корзины</a></li>
   <li class="cabinet-menu__item"><a href="/admin/coupon" class="cabinet-menu__links" title="Купоны">Купоны</a></li>
   <li class="cabinet-menu__item"><a href="/admin/allmg" class="cabinet-menu__links" title="Менеджеры">Менеджеры</a></li>
   <li class="cabinet-menu__item"><a href="/admin/operators" class="cabinet-menu__links" title="Операторы">Операторы</a></li>
   <li class="cabinet-menu__item"><a href="/admin/roles" class="cabinet-menu__links" title="Роли">Права пользователей</a></li>
   <li class="cabinet-menu__item"><a href="/admin/allprofile" class="cabinet-menu__links" title="Профили">Профили</a></li>
   <li class="cabinet-menu__item"><a href="/admin/clients" class="cabinet-menu__links" title="Клиенты">Клиенты</a></li>
   <li class="cabinet-menu__item"><a href="/admin/allbook" class="cabinet-menu__links" title="Статьи">Статьи</a></li>
   <li class="cabinet-menu__item"><a href="/admin/category" class="cabinet-menu__links" title="Категории">Категории</a></li>
   <li class="cabinet-menu__item"><a href="/admin/send" class="cabinet-menu__links" title="Категории">Реквизиты</a></li>
   <li class="cabinet-menu__item"><a href="/admin/businesscategory" class="cabinet-menu__links" title="Категории">Бизнес категории</a></li>
   <li class="cabinet-menu__item"><a href="/admin/drop" class="cabinet-menu__links" title="Категории">Брошенные корзины</a></li>
   <li class="cabinet-menu__item"><a href="/admin/upprice" class="cabinet-menu__links" title="Спеццены">Спец цены</a></li>
   <li class="cabinet-menu__item"><a href="/admin/price" class="cabinet-menu__links" title="Спеццены">Загрузить прайс лист</a></li>
   <li class="cabinet-menu__item"><a href="/admin/thisbrand" class="cabinet-menu__links" title="Бренды">Бренды</a></li>
   <li class="cabinet-menu__item"><a href="/admin/fids" class="cabinet-menu__links" title="Фиды">Фиды</a></li>
   <?php } ?>
</ul>