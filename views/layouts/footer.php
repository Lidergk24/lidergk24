</div>
<footer>
<?php $footerS = explode('/', $_SERVER['REQUEST_URI']);
if ($footerS[1] != 'loyalty' && $footerS[1] != 'cart') { ?>
   <section class="subscribe">
      <div class="container">
         <div class="subscribe-wrapper">
            <h2 class="subscribe__title">ПОДПИШИСЬ И ПОЛУЧИ СКИДКУ 5%</h2>
            <form method="post" class="form-subscribe">
               <label><input type="text" name="name" placeholder="Ваше имя*" class="subscribe_name subscribe-input" maxlength="20" autocomplete="off"></label>
               <label><input type="text" name="mail" placeholder="E-mail*" class="subscribe_email subscribe-input" maxlength="40" autocomplete="off"></label>
               <button type="submit" id ='subscribe-submit' class="btn btn_black">Подписаться</button>
            </form>
            <div id="signup-response"></div>
         </div>
      </div>
   </section>
<?php } ?>
   <div class="footer__top">
      <div class="container">
         <ul class="footer-menu">
            <div class="footer-menu-heading">Покупателям</div>
            <li class="footer-menu__item"><a href="/discount" class="footer-menu__links" title="Акции">Акции</a></li>
            <li class="footer-menu__item"><a href="/loyalty" class="footer-menu__links" title="Программа лояльности">Программа лояльности</a></li>
            <li class="footer-menu__item"><a href="/postponement" class="footer-menu__links" title="Отсрочка платежа">Возврат товара</a></li>
            <li class="footer-menu__item"><a href="/privacy" class="footer-menu__links" title="Политика конфиденциальности">Политика конфиденциальности</a></li>
            <li class="footer-menu__item"><a href="/agreement" class="footer-menu__links" title="Пользовательское соглашение">Пользовательское соглашение</a></li>
         </ul>
         <ul class="footer-menu">
            <div class="footer-menu-heading">Бизнесу</div>
            <li class="footer-menu__item"><a href="/brandy" class="footer-menu__links" title="">Бренды</a></li>
            <li class="footer-menu__item"><a href="/postavshchikam" class="footer-menu__links" title="Поставщикам">Поставщикам</a></li>
            <li class="footer-menu__item"><a href="/brendirovanie" class="footer-menu__links" title="Брендирование">Брендирование</a></li>
            <li class="footer-menu__item"><a href="/manager" class="footer-menu__links" title="Вызов менеджера">Вызов менеджера</a></li>
         </ul>
         <ul class="footer-menu">
            <div class="footer-menu-heading">ЛИДЕР</div>
            <li class="footer-menu__item"><a href="/about" class="footer-menu__links" title="О компании">О компании</a></li>
            <li class="footer-menu__item"><a href="/article" class="footer-menu__links" title="Новости">Новости</a></li>
            <li class="footer-menu__item"><a href="/vacancy" class="footer-menu__links" title="Вакансии">Вакансии</a></li>
            <li class="footer-menu__item"><a href="/brand/The%20Lider" class="footer-menu__links" title="Продукция СТМ">Продукция СТМ</a></li>
         </ul>
         <ul class="footer-menu">
            <div class="footer-menu-heading">ООО "ЛИДЕР", <?php echo date('Y'); ?> </div>
            <li class="footer-menu__item"><a class="footer-menu__links">Все права защищены</a></li>
            <div class="footer-phone-box">
               <p class="phone-sign-footer">Для Москвы и МО</p>
               <a href="tel:+74953080069" class="footer-phone" title="8 (495) 308-00-69">8 (495) 308-00-69</a>
            </div>
            <div class="footer-phone-box">
               <p class="phone-sign-footer">Бесплатно по РФ</p>
               <a href="tel:88002223236" class="footer-phone" title="8 (800) 222-32-36">8 (800) 222-32-36</a>
            </div>
            <div class="ya-metricks">
               <a class="ya-market-container" href="https://market.yandex.ru/shop--ooo-lider/541961/reviews" target="_blank">
                  <img class="ya-market" src='/template/images/Stock/ya-market.png'>
                  <span class="ya-market-sign"> market.yandex.ru </span>
               </a>
            </div>
            <div class="payments"><img class="payment-one" src='/template/images/Stock/visa.svg'><img class="payment-one" src='/template/images/Stock/mastercard.svg'><img class="payment-one" src='/template/images/Stock/mir.svg'></div>
           
         </ul>

      </div>
   </div>
   <div class="footer__bottom">
      <div class="container">
         <div class="copyright">
            <p>© ООО "Лидер", <?php echo date('Y'); ?></p>
         </div>
      </div>
   </div>
</footer>
<div class="overlay"></div>
</div>

<script src="/template/js/jquery.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
<script src="/template/js/libs.min.js"></script>
<script rel="preload" src="/template/js/jquery.maskedinput.min.js"></script>
<script rel="preload" src="/template/js/main.js"></script>
<?php
$footer = explode('/', $_SERVER['REQUEST_URI']);
if ($footer[1] == 'cart') { ?>
   <script rel="preload" src="/template/js/CartLogic.js"></script>
<?php } ?>
<script>
   $(document).click(function(event) {
      if ($(event.target).closest(".search__result").length)
         return;
      $(".search__result").fadeOut("slow");
      event.stopPropagation();
   });


   $(".add-cart").click(function() {

      var id = $(this).attr("data-id");

      var allCountInform = 0;
      if ($(".boxCountWhere").hasClass("boxCountWhereBlock")) {
         var allCountInform = $(this).closest('.product-section__information_quantity').find('input[name=count_product]').val();
      } else {
         $(this).closest('.product-section__information_quantity').find("input[name=count_product]").each(function(index, el) {

            allCountInform += parseFloat($(el).val());

         });
      }

      console.log(allCountInform);
      cart_add_ajax(id, allCountInform);

   });
</script>
<script type="text/javascript">
   (function(m, e, t, r, i, k, a) {
      m[i] = m[i] || function() {
         (m[i].a = m[i].a || []).push(arguments)
      };
      m[i].l = 1 * new Date();
      k = e.createElement(t), a = e.getElementsByTagName(t)[0], k.async = 1, k.src = r, a.parentNode.insertBefore(k, a)
   })
   (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

   ym(57470944, "init", {
      clickmap: true,
      trackLinks: true,
      accurateTrackBounce: true,
      webvisor: true
   });
</script>
<script type="application/ld+json">
   {
      "@context": "http://schema.org",

      "@type": "Organization",

      "name": "Лидер",

      "alternateName": "Лидер - снабжение ресторанов и кафе",

      "description": "Одноразовая посуда | бытовая химия | средства гигиены и многое другое",

      "url": "https://lider-gk24.ru",

      "email": "sale@lider-gk24.ru",

      "legalName": "ООО Лидер",

      "logo": "https://lider-gk24.ru/template/images/icons/logo.png",

      "address": {

         "@type": "PostalAddress",

         "addressCountry": "RU",

         "addressLocality": "Москва",

         "addressRegion": "Москва",

         "postalCode": "115088",

         "streetAddress": "ул. Угрешская, д. 2, строение 53"

      },

      "telephone": "8 (800) 222-32-36",

      "sameAs": ["https://www.facebook.com/%D0%9E%D0%9E%D0%9E-%D0%9B%D0%B8%D0%B4%D0%B5%D1%80-111295050359259/?modal=admin_todo_tour", "https://www.instagram.com/ooo__lider/", "https://www.youtube.com/channel/UCdsRtxWoWENVyKrZT15WfYg", "https://vk.com/lidersale"]

   }
</script>
</body>

</html>