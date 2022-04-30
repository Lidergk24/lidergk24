<?php include ROOT . '/views/layouts/header.php'; ?>
<div class="breadcrumb-wrapper">
   <div class="container">
      <ul class="breadcrumb">
         <li><a href="/" title="Главная"><span>ГЛАВНАЯ</span></a></li>
         <li><a title="Контакты"><span>Контакты</span></a></li>
      </ul>
   </div>
</div>
<section class="contacts">
   <div class="container">
      <h1>Контакты</h1>
      <div class="maps shadow-50">
      <iframe src="https://yandex.ru/map-widget/v1/?um=constructor%3Af9d6084d03cf82dbbb514ba4b58682c18570ee208571a5d6a78d9a53f2ab346c&amp;source=constructor" width="100%" height="681" frameborder="0"></iframe>
      </div>
      <div class="contacts__wrapper w-100">
         <div class="contacts__company contacts__wrapper_item">
            <div class="company__name">The Lider</div>
            <div class="contacts__company_box">
               <div class="contacts__company_box_info contacts__company_box_info_address">
                  <div class="contacts__company_box_icon"><img src="/template/images/Stock/location.png" alt="Адрес"></div>
                  <div class="contacts__company_box_text">
                     <span class="contacts__company_box_title">Наш Адрес</span>
                     <p>г. Москва. ул. Угрешская, д. 2, строение 53</p>
                     <a href="/delivery" class="links-accent" target="_blank" title="Подробнее о доставке">Подробнее о доставке</a>
                  </div>
               </div>
               <div class="contacts__company_box_info">
                  <div class="contacts__company_box_icon"><img src="/template/images/Stock/clock.png" alt=""></div>
                  <div class="contacts__company_box_text">
                     <span class="contacts__company_box_title ">Режим работы</span>
                     <p>Пн.-Пт.: 8.00 - 19.00,   Сб.-Вс.: 10.00 - 16.00</p>
                  </div>
               </div>
            </div>
            <div class="contacts__company_box">
               <div class="contacts__company_box_info contacts__company_box_info_contact">
                  <span class="contacts__company_box_title">Контакты</span>
                  <ul class="contacts-list">
                     <li class="contacts-list__item">
                        <a href="tel:+74953080069" class="contacts-list__phone">
                        <span class="phone-icon"><img src="/template/images/Stock/phone.png" alt="для Москвы и МО"></span>
                        <span class="phone-text">8 (495) 308-00-69</span>
                        </a>
                        <span class="contacts-list__item_span">—  для Москвы и МО</span>
                     </li>
                     <li class="contacts-list__item">
                        <a href="tel:+78002223236" class="contacts-list__phone">
                        <span class="phone-icon"><img src="/template/images/Stock/phone.png" alt="бесплатно по РФ"></span>
                        <span class="phone-text">8 (800) 222 32 36</span>
                        </a>
                        <span class="contacts-list__item_span">—  бесплатно по РФ</span>
                     </li>
                  </ul>
                  
               </div>
            </div>
         </div>
         <div class="contacts-feedback contacts__wrapper_item">
            <div class="contacts-feedback__title">Обратная связь</div>
            <ul class="feedback-list">
               <li class="feedback-list__item">
                  <a href="mailto:sale@lider-gk24.ru" class="feedback-list__links">
                  <span class="feedback-list__item_icon"><img src="/template/images/Stock/email.png" alt="Для заказов"></span>
                  <span class="feedback-list__links_text">sale@lider-gk24.ru</span>
                  </a>
                  <p class="feedback-list__item_text">—  Для заказов</p>
               </li>
               <li class="feedback-list__item">
                  <a href="mailto:info@lider-gk24.ru" class="feedback-list__links">
                  <span class="feedback-list__item_icon"><img src="/template/images/Stock/email.png" alt="Общие вопросы"></span>
                  <span class="feedback-list__links_text">info@lider-gk24.ru</span>
                  </a>
                  <p class="feedback-list__item_text">—  Для коммерческих предложений</p>
               </li>
               <!-- <li class="feedback-list__item">
                  <a href="mailto:li@lider-gk24.ru" class="feedback-list__links">
                  <span class="feedback-list__item_icon"><img src="/template/images/Stock/email.png" alt="логотипированной продукции"></span>
                  <span class="feedback-list__links_text">li@lider-gk24.ru</span>
                  </a>
                  <p class="feedback-list__item_text">—  Заявки на расчет <span>логотипированной продукции</span></p>
               </li>
               <li class="feedback-list__item">
                  <a href="mailto:li@lider-gk24.ru" class="feedback-list__links">
                  <span class="feedback-list__item_icon"><img src="/template/images/Stock/email.png" alt="от поставщиков"></span>
                  <span class="feedback-list__links_text">li@lider-gk24.ru</span>
                  </a>
                  <p class="feedback-list__item_text">—  Предложения <span>от поставщиков</span></p>
               </li> -->
            </ul>
         </div>
      </div>
   </div>
</section>

<?php include ROOT . '/views/layouts/footer.php'; ?>