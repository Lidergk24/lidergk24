<?php include ROOT . '/views/layouts/header.php'; ?>
<div class="breadcrumb-wrapper">
   <div class="container">
      <ul class="breadcrumb">
         <li><a href="/" title="Главная"><span>ГЛАВНАЯ</span></a></li>
         <li><a><span>Вызвать торгового представителя</span></a></li>
      </ul>
   </div>
</div>
<section class="representative">
   <div class="container">
      <h1>Вызвать торгового представителя</h1>
      <div class="box-text">
         <p><strong class="color_red text-uppercase font-bold">Внимание!</strong> Сервисная услуга «Вызов торгового представителя» доступна для клиентов в Москве. Теперь вы можете оценить качество и разнообразие наших товаров прямо у себя в офисе!</p>
         <p>Если вас заинтересовала наша продукция и ассортимент, заполните, пожалуйста, представленную ниже заявку.</p>
         <p>В течение рабочего дня с вами свяжется торговый представитель компании «Лидер» и уточнит, какие товары вам необходимы. В согласованное с вами время он привезет образцы из заинтересовавших вас тематик, подробно расскажет об имеющемся ассортименте.</p>
      </div>
      <?php if (isset($callMeManager)){ ?>
               <ul class="error_flag">
                  <li> - Ожидайте звонка</li>
               </ul>
               <?php } else {
                  if (isset($errors) && is_array($errors)): ?>
               <ul class="error_flag">
                  <?php foreach ($errors as $error): ?>
                  <li> - <?php echo $error; ?></li>
                  <?php endforeach; ?>
               </ul>
               <?php endif; } ?>
      <form method="post" class="form-representative">
         <div class="form-group">
            <label class="form-group__label">
            <span class="form-group__subtitle">Название компании*</span>
            <input type="text" name="name_company" value="<?php echo $company; ?>" placeholder="LIDER" required>
            </label>
            <label class="form-group__label">
            <span class="form-group__subtitle">Имя контактного лица*</span>
            <input type="text" name="nameClient" value="<?php echo $clients; ?>" required>
            </label>
            <label class="form-group__label">
            <span class="form-group__subtitle">Телефон*</span>
            <input type="text" name="phone" value="<?php echo $clientsphone; ?>" placeholder="+7 (___) ___ - __ - __" required>
            </label>
            <label class="form-group__label">
            <span class="form-group__subtitle">Комментарий</span>
            <input type="text" name="comment">
            </label>
         </div>
         <div class="form-group">
            <h3 class="form-group__title">
               ВЫБЕРЕТЕ ИНТЕРЕСУЮЩИЕ ВАС КАТЕГОРИИ ТОВАРА:
            </h3>
            <ul class="list-checkbox">
               <li class="list-checkbox__item">
                  <label class="checkbox">
                  <input class="checkbox-inp" type="checkbox" value="Биоразлагаемая посуда" name="checkbox[]">
                  <span class="checkbox-custom"></span>
                  <span class="label">Биоразлагаемая посуда</span>
                  </label>
               </li>
               <li class="list-checkbox__item">
                  <label class="checkbox">
                  <input class="checkbox-inp" type="checkbox" value="Бытовая химия" name="checkbox[]">
                  <span class="checkbox-custom"></span>
                  <span class="label">Бытовая химия</span>
                  </label>
               </li>
               <li class="list-checkbox__item">
                  <label class="checkbox">
                  <input class="checkbox-inp" type="checkbox" value="Дезенфицирующие средства" name="checkbox[]">
                  <span class="checkbox-custom"></span>
                  <span class="label">Дезенфицирующие средства</span>
                  </label>
               </li>
               <li class="list-checkbox__item">
                  <label class="checkbox">
                  <input class="checkbox-inp" type="checkbox" value="Диспенсеры" name="checkbox[]">
                  <span class="checkbox-custom"></span>
                  <span class="label">Диспенсеры</span>
                  </label>
               </li>
               <li class="list-checkbox__item">
                  <label class="checkbox">
                  <input class="checkbox-inp" type="checkbox" value="Инвентарь для уборки" name="checkbox[]">
                  <span class="checkbox-custom"></span>
                  <span class="label">Инвентарь для уборки</span>
                  </label>
               </li>
               <li class="list-checkbox__item">
                  <label class="checkbox">
                  <input class="checkbox-inp" type="checkbox" value="Одноразовая посуда" name="checkbox[]">
                  <span class="checkbox-custom"></span>
                  <span class="label">Одноразовая посуда</span>
                  </label>
               </li>
               <li class="list-checkbox__item">
                  <label class="checkbox">
                  <input class="checkbox-inp" type="checkbox" value="Одноразовая упаковка" name="checkbox[]">
                  <span class="checkbox-custom"></span>
                  <span class="label">Одноразовая упаковка</span>
                  </label>
               </li>
               <li class="list-checkbox__item">
                  <label class="checkbox">
                  <input class="checkbox-inp" type="checkbox" value="Посуда для фуршета" name="checkbox[]">
                  <span class="checkbox-custom"></span>
                  <span class="label">Посуда для фуршета</span>
                  </label>
               </li>
               <li class="list-checkbox__item">
                  <label class="checkbox">
                  <input class="checkbox-inp" type="checkbox" value="Одноразовые контейнеры" name="checkbox[]">
                  <span class="checkbox-custom"></span>
                  <span class="label">Одноразовые контейнеры</span>
                  </label>
               </li>
               <li class="list-checkbox__item">
                  <label class="checkbox">
                  <input class="checkbox-inp" type="checkbox" value="Пакеты" name="checkbox[]">
                  <span class="checkbox-custom"></span>
                  <span class="label">Пакеты</span>
                  </label>
               </li>
               <li class="list-checkbox__item">
                  <label class="checkbox">
                  <input class="checkbox-inp" type="checkbox" value="Перчатки" name="checkbox[]">
                  <span class="checkbox-custom"></span>
                  <span class="label">Перчатки</span>
                  </label>
               </li>
               <li class="list-checkbox__item">
                  <label class="checkbox">
                  <input class="checkbox-inp" type="checkbox" value="Сервировка стола" name="checkbox[]">
                  <span class="checkbox-custom"></span>
                  <span class="label">Сервировка стола</span>
                  </label>
               </li>
               <li class="list-checkbox__item">
                  <label class="checkbox">
                  <input class="checkbox-inp" type="checkbox" value="Профессиональная одежда" name="checkbox[]">
                  <span class="checkbox-custom"></span>
                  <span class="label">Профессиональная одежда</span>
                  </label>
               </li>
               <li class="list-checkbox__item">
                  <label class="checkbox">
                  <input class="checkbox-inp" type="checkbox" value="Профессиональная химия" name="checkbox[]">
                  <span class="checkbox-custom"></span>
                  <span class="label">Профессиональная химия</span>
                  </label>
               </li>
               <li class="list-checkbox__item">
                  <label class="checkbox">
                  <input class="checkbox-inp" type="checkbox" value="Для салона красоты" name="checkbox[]">
                  <span class="checkbox-custom"></span>
                  <span class="label">Для салона красоты</span>
                  </label>
               </li>
               <li class="list-checkbox__item">
                  <label class="checkbox">
                  <input class="checkbox-inp" type="checkbox" value="Средства гигиены" name="checkbox[]">
                  <span class="checkbox-custom"></span>
                  <span class="label">Средства гигиены</span>
                  </label>
               </li>
               <li class="list-checkbox__item">
                  <label class="checkbox">
                  <input class="checkbox-inp" type="checkbox" value="Товары для кондитера" name="checkbox[]">
                  <span class="checkbox-custom"></span>
                  <span class="label">Товары для кондитера</span>
                  </label>
               </li>
               <li class="list-checkbox__item">
                  <label class="checkbox">
                  <input class="checkbox-inp" type="checkbox" value="Товары для кухни" name="checkbox[]">
                  <span class="checkbox-custom"></span>
                  <span class="label">Товары для кухни</span>
                  </label>
               </li>
               <li class="list-checkbox__item">
                  <label class="checkbox">
                  <input class="checkbox-inp" type="checkbox" value="Товары для офиса" name="checkbox[]">
                  <span class="checkbox-custom"></span>
                  <span class="label">Товары для офиса</span>
                  </label>
               </li>
               <li class="list-checkbox__item">
                  <label class="checkbox">
                  <input class="checkbox-inp" type="checkbox" value="Упаковка из ЭКО-картона" name="checkbox[]">
                  <span class="checkbox-custom"></span>
                  <span class="label">Упаковка из ЭКО-картона</span>
                  </label>
               </li>
            </ul>
         </div>
         <button type="submit" name="submit" class="btn btn_black">Отправить заявку</button>
      </form>
   </div>
</section>

<?php include ROOT . '/views/layouts/footer.php'; ?>
