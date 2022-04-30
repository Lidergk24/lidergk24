<div id="cabinet-menu-block" class="non-activeCabinetMenu">
      <?php if (!User::isGuest()) { ?>
            <ul class="cabinet-menu">
                  <li class="cabinet-menu__item close-button-cabinet-menu">×
                  </li>
                  <li class="cabinet-menu__item ">
                  </li>
                  <li class="cabinet-menu__item"><a href="/cabinet" class="cabinet-menu__links">
                              <img src="/template/images/Stock/user.svg" alt="Профиль">
                              Профиль</a></li>
                  <li class="cabinet-menu__item"><a href="/cabinet/history" class="cabinet-menu__links">
                              <img src="/template/images/Stock/003-clipboard.svg" alt="Мои заказы"> Заказы</a></li>
                  <li class="cabinet-menu__item"><a href="/cabinet/edit" class="cabinet-menu__links">
                              <img src="/template/images/Stock/invoice.svg" alt="Мои реквизиты">
                              Реквизиты</a></li>
                  <li class="cabinet-menu__item"><a href="/cabinet/adress" class="cabinet-menu__links">
                              <img src="/template/images/Stock/001-truck.svg" alt="Промокоды">
                              Адреса доставки</a></li>
                  <li class="cabinet-menu__item">

                        <a href="/cabinet/sale" class="cabinet-menu__links">
                              <img src="/template/images/Stock/price-tag.svg" alt="Промокоды"> Промокоды</a>
                  <li class="cabinet-menu__item">
                        <a href="/user/logout/" class="cabinet-menu__links logout-cabinet" title="Выйти">
                              <span class=""><img src="/template/images/Stock/logout.svg" alt="Выйти"></span>
                              <span class="header__links_text">Выйти</span>
                        </a>
                  </li>
            </ul>
      <?php } ?>
</div>