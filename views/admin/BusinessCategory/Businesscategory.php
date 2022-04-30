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
            <li><a title="Бизнес категории"><span>Бизнес категории</span></a>
            </li>
         </ul>
         <h1>Бизнес категории (добавить/редактировать)</h1>
        
         <form method="post" class="form-add-file form-admin-cabinet form-add-manager">
            <div class="form-group">
               <label>
               <span class="form-group__title">Название бизнес категории*</span>
               <input type="text" name="biz" class="addCats" required>
               </label>
               <label>
               <span class="form-group__title">Полное название*</span>
               <input type="text" name="title" class="addCats" required>
               </label>
               <label>
               <span class="form-group__title">Описание*</span>
               <input type="text" name="description" class="addCats" required>
               </label>
               <button class="btn btn_black buttonHits" name="submit" type="submit">Добавить категорию</button>
               
            </div>
            
         </form>
         <h1>Родительские категории</h1>
         <div class="sales-table__admin table w-100">
            <div class="table__head">
               <div class="table__th" style="display: none;">#</div>
               <div class="table__th sales-table__banner">Категория</div>
               <div class="table__th sales-table__name">Тайтл</div>
               <div class="table__th sales-table__description">Дескрипшн</div>
               <div class="table__th sales-table__actions">Удалить</div>
            </div>
            <form class="table__body">
               <?php 
               for ($i=0; $i < count($allBizCat); $i++) { 
                  ?>
               <div class="table-body_line draggable" draggable="true" id = <?php echo $allBizCat[$i]['id']; ?>>
                     <div name="order" class="table__td count-cat" style="position: absolute;">
                     <?php echo $i; ?>
                     </div>
                     <div class="table__td sales-table__banner">
                        <a href="/admin/podbizcat/<?php echo $allBizCat[$i]['id']; ?>"><?php echo $allBizCat[$i]['categoryName']; ?></a>
                     </div>
                     <div class="table__td sales-table__name categoryTitle">
                        <input name="categoryTitle" tyle="font-size:14px; padding:4px; color:#212121;" type="text" value="<?php echo $allBizCat[$i]['categoryTitle']; ?>"title="<?php echo $allBizCat[$i]['categoryTitle']; ?>"></input>
                     </div>
                     <div class="table__td sales-table__description categoryDescription">
                     <input name="categoryDescription" style="font-size:14px; padding:4px; color:#212121;" type="text" title="<?php echo $allBizCat[$i]['categoryDescription']; ?>" value="<?php echo $allBizCat[$i]['categoryDescription']; ?>"></input>
                     </div>
                     <div class="table__td sales-table__actions">
                        <a href="/admin/metacat/<?php echo $allBizCat[$i]['cat_code']; ?>" class="btn-delete deleteBanner" title="Удалить">
                        <input type="hidden" name="delBizCat" value="<?php echo $allBizCat[$i]['id']; ?>">
                        <img src="/template/images/Stock/delete.svg" alt="Удалить">
                        </a>
                     </div>
               </div>
               <?php } ?>
            </form>
         </div>
      </div>
   </div>
</main>
<?php include ROOT . '/views/admin/Index/Footer.php'; ?>
<style>
   .dragging {
      opacity: .5;
   }
   .table-body_line {
   margin: 10px 0;
    box-shadow: 0 4px 12px rgb(0 0 0 / 15%);
    border-radius: 4px;
   }
</style>
<script>
   $('.sales-table__actions').click(function(e){
   e.preventDefault();
   var confirmS = confirm('Удалить категорию?');
    if(confirmS == true){
        var delBizCat = $(this).closest('.table-body_line').find('input[name="delBizCat"]').val();
        
        $.ajax({
             type: "POST",
             url: "/admin/businesscategory",
             data: {idCat: delBizCat},
              success: function (data) {
                    location.reload();

             }
         });
    }
   
   });
;
const dragAndDrop = () => {
   const draggables = document.querySelectorAll('.draggable');
   const containers = document.querySelectorAll('.table__body');
   containers[0].addEventListener("change", e => {
      e.preventDefault();
      sendNewNumeration();
   })
   draggables.forEach(draggable => {
      draggable.addEventListener('dragstart', () => {
         draggable.classList.add('dragging');
      })
      draggable.addEventListener('dragend', () => {
         draggable.classList.remove('dragging');
         renumerateElemets();
         sendNewNumeration();
      })
   })
   containers.forEach(container => {
      container.addEventListener('dragover', e => {
         e.preventDefault()
         const afterElement = getDragAfterElement(container, e.clientY)
         const draggable = document.querySelector('.dragging')
         if (afterElement == null) {
            container.appendChild(draggable)
         } else {
            container.insertBefore(draggable, afterElement)
         }
      })
})
   function getDragAfterElement(container, y) {
      const draggableElements = [...container.querySelectorAll('.draggable:not(.dragging)')]

      return draggableElements.reduce((closest, child) => {
         const box = child.getBoundingClientRect()
         const offset = y - box.top - box.height / 2
         if (offset < 0 && offset > closest.offset) {
            return { offset: offset, element: child }
         } else {
            return closest
         }
      }, { offset: Number.NEGATIVE_INFINITY }).element
}
   function renumerateElemets() {
      const categoriesNums = document.getElementsByClassName("count-cat");
      const categoriesLength = categoriesNums.length;
      for (let i = 0; i < categoriesLength; i++) {
         categoriesNums[i].parentElement.firstElementChild.innerText = i;
      }
   }
   function sendNewNumeration() {
      let order = [];
      let ids = [];
      let titles = [];
      let descriptions = [];
      const categoriesNums = document.getElementsByClassName("count-cat");
      const categoriesLength = categoriesNums.length;
      for (let i = 0; i < categoriesLength; i++) {
         ids.push(categoriesNums[i].parentElement.id);
         order.push(categoriesNums[i].parentElement.firstElementChild.innerText);
         titles.push(categoriesNums[i].parentElement.querySelector(".categoryTitle").firstElementChild.value);
         descriptions.push(categoriesNums[i].parentElement.querySelector(".categoryDescription").firstElementChild.value);
      }
      $.ajax({
             type: "POST",
             url: "/admin/renumerateBusinessCat",
             data: {order: order, ids:ids, titles:titles, descriptions:descriptions},
              success: function (data) {
                    location.reload();

             }
         });
   }
}
dragAndDrop();
</script>