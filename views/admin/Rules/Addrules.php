<?php include ROOT . '/views/admin/Index/Header.php'; ?>
<main class="main-cabinet-user main-cabinet-user-view main-cabinet-admin">
   <div class="container">
      <div class="cabinet-sidebar">
         <div class="btn-close__menu"></div>
         <?php include ROOT . '/views/admin/Index/Sidebar.php'; ?>
      </div>
      <div class="main-cabinet-user__content main-cabinet-admin__content">
         <ul class="breadcrumb breadcrumb-cabinet">
            <li><a href="/admin" title="Главная"><span>ГЛАВНАЯ</span></a></li>
            <li><a href="/admin/allrules" title="Правила"><span>правила корзины</span></a></li>
            <li><a title="Добавить правило"><span>Добавить правило</span></a></li>
         </ul>
         <h1>Добавить правило</h1>
          <?php
             if($addRules){ ?>
                 <p class="rulse_no_error">Ok! Правило добавлено!</p>
            <?php } else { } ?>
         <form method="post" class="form-coupons form-rulers form-admin-cabinet">
            <div class="form-rulers__wrapper">
               <label>
               <span class="form-group__title">Выберите товары первой группы (внутренний код или название)</span> 
               <input type="text" name="name_rules" class="name_rules" autocomplete="off" required placeholder="Поиск по коду товара">
               <div class="form-search__result"></div>
               </label>
               <label>
                  <span class="form-group__title">Условие для применения</span>
                  <select name="rules_select" class="select-admin select-form">
                     <option value="Больше">Больше</option>
                     <option value="Равно">Равно</option>
                  </select>
               </label>
               <label>
               <span class="form-group__title">Указать количество</span>
               <input type="text" placeholder="Например 10" maxlength="20" name="count_rules" autocomplete="off" required>
               </label>
               <label>
               <span class="form-group__title">Применить на текушем уровне скидку, %</span>
               <input type="text" name="form_procent" placeholder="Скидка в %" autocomplete="off">
               </label>
               <label class="w-100">
               <span class="form-group__title">Применить на текушем уровне скидку, ₽</span>
               <input type="text" name="form_rub" placeholder="Скидка в рублях" autocomplete="off">
               </label>
            </div>
            <button type="submit" name="submit" class="btn btn_black">Создать правило</button>
         </form>


         <form method="post" name="groupRuleForm" class="form-coupons form-rulers form-admin-cabinet" action="/admin/setRulesGroup" style="margin-top:20px">
            <div class="form-rulers__wrapper">
               <label>
               <span class="form-group__title"> Первая группа товаров (коды)</span> <span id="addFirstGroupItem" >+</span>
               <div id="addFirstGroupItemContainer"></div>
               </label>
               <label>
               <label>
               <span class="form-group__title"> Вторая группа товаров (коды)</span> <span id="addSecondGroupItem" >+</span>
               <div id="addSecondGroupItemContainer"></div>
               </label>
               <label>
               <span class="form-group__title">Применить на текушем уровне скидку, %</span>
               <input type="text" name="form_procent" placeholder="Скидка в %" autocomplete="off">
               </label>
               <label class="w-100">
               <span class="form-group__title">Применить на текушем уровне скидку, ₽</span>
               <input type="text" name="form_rub" placeholder="Скидка в рублях" autocomplete="off">
               </label>
            </div>
            <button class="btn btn_black">Создать группу скидок</button>
         </form>
      </div>
   </div>
</main>

<?php include ROOT . '/views/admin/Index/Footer.php'; ?>
<style>
   .cartRuleGroupItem {
      width: 100%;
      display: flex;
   }
   .cartRuleGroupItem input{
      width: 50%;
   }
</style>
<script>
    $('#addFirstGroupItem').click(function() {
       const markupItem = `<div class='cartRuleGroupItem'><input type="text" name="part_nums1[]" class="name_rules" autocomplete="off" required placeholder="">
       <input type="text" placeholder="min" maxlength="20" name="amounts1[]" autocomplete="off" required>
       <label>
         <select name="conditions1[]" class="select-admin select-form">
            <option value="Больше">Больше</option>
            <option value="Равно">Равно</option>
         </select>
      </label>
      <div>
       `;
       document.querySelector('#addFirstGroupItemContainer').insertAdjacentHTML('beforeend', markupItem);
    })
    $('#addSecondGroupItem').click(function() {
       const markupItem = `<div class='cartRuleGroupItem'><input type="text"  name="part_nums2[]"  class="name_rules2[]" autocomplete="off" required placeholder="">
       <input type="text" placeholder="min" maxlength="20" name="amounts2[]" autocomplete="off" required> 
       <label>
         <select name="conditions2[]" class="select-admin select-form">
            <option value="Больше">Больше</option>
            <option value="Равно">Равно</option>
         </select>
      </label>
       <div>`;
       document.querySelector('#addSecondGroupItemContainer').insertAdjacentHTML('beforeend', markupItem);
    })
    $('.name_rules').keyup(function() {
        
    var searchItems = $('input[name="name_rules"]').val();
   
        if (searchItems.trim().length > 2) {
         
            $.ajax({
                type: 'post',
                url: "/views/admin/Rules/SearchItem.php",
                data: {
                    searchItem: searchItems.trim()
                },
                dataType: 'TEXT',
                success: function(data) {
                    $('.form-search__result').css('position', 'relative');
                    $(".form-search__result").html(data).fadeIn();
                    $(".line").click(function(){
                         var line = $(this).closest('.line').find('.code_search_ajax').html();
                         var lineReplace = line.replace(/[^0-9-]/gi, '');
                         $('input[name="name_rules"]').val(lineReplace);
                         $(".form-search__result").fadeOut("slow");
                    });
                }
            }); 
        } 
    });
  
   $('.rulse_no_error').delay(3000).fadeOut(); 
</script> 