<?php include ROOT . '/views/admin/Index/Header.php'; ?>
<main class="main-cabinet-user main-cabinet-user-view main-cabinet-admin">
   <div class="container">
      <div class="cabinet-sidebar">
         <div class="btn-close__menu"></div>
         <?php include ROOT . '/views/admin/Index/Sidebar.php'; 
         $environment = include_once($_SERVER['DOCUMENT_ROOT'] . '/config/environment.php');?>
      </div>
      <div class="main-cabinet-user__content main-cabinet-admin__content">
         <ul class="breadcrumb breadcrumb-cabinet">
            <li><a href="/admin" title="Главная"><span>ГЛАВНАЯ</span></a></li>
            <li><a href="<?php echo $_SERVER['HTTP_REFERER']; ?>" title="Банеры"><span>Категория</span></a></li>
            <li><a title="<?php echo $metaCatInfo['cat_name']; ?>"><span><?php echo $metaCatInfo['cat_name']; ?></span></a></li>
         </ul>
         <form enctype="multipart/form-data" method="POST" class="form-add-file form-admin-cabinet">
            <?php if(!empty($infoEndcat['cat_icon'])){ ?>
            <span>Иконка категории:</span><img style="display: inline-block;" src="<?php echo $environment["base_url"]; ?>/template/images/icons/<?php echo $infoEndcat['cat_icon']; ?>">
            <?php } ?>
            <input type="file" name="filename">
            <label>
            <span class="form-group__title">TITLE категории</span>
            <input name="titleCategory" value="<?php echo $metaCatInfo['cat_title']; ?>" required>
            </label>
            <label>
            <span class="form-group__title">Description категории</span>
            <input name="descriptionCategory" value="<?php echo $metaCatInfo['cat_description']; ?>" required>
            </label>
            <label>
            <span class="form-group__title">H1 категории</span>
            <input name="hCategory" value="<?php echo $metaCatInfo['cat_h1']; ?>" required>
            </label>
            <textarea cols="80" id="editor1" rows="10" name="textCategory" style="visibility: hidden; display: none;"><?php echo $metaCatInfo['cat_desc']; ?></textarea>
            <script type="text/javascript">
               CKEDITOR.replace( 'editor1');
            </script>
            <button class="btn btn_black" name="submit" type="submit">Добавить баннер</button>
            <br />
            <label for="filters">
                <span class="form-group__title">Фильтры категории</span>
            </label>
            <div class="all-filters" name="filters">
                <?php foreach($catFilters as $ind => $flt) : ?>
                    <div class="filter-container draggable" draggable="true" data-order="<?=$ind?>" data-filter-id="<?=$flt[id]?>">
                        <div name="order" class="count-cat" style="position: absolute;"><?=$ind+1?>.</div>
                        <label class="filter"><?=$flt[attribute_name]?></label>
                        <input class="filters" type="checkbox" checked />
                    </div>
                <?php endforeach ?>
            </div>
         </form>
      </div>
   </div>
</main>
<?php include ROOT . '/views/admin/Index/Footer.php'; ?>
<script>
const dragAndDrop = () => {
   const draggables = document.querySelectorAll('.draggable');
   const containers = document.querySelectorAll('.all-filters');
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
         categoriesNums[i].parentElement.firstElementChild.innerText = i+1;
      }
   }
   function sendNewNumeration() {
      let order = [];
      let ids = [];
      //let titles = [];
      //let descriptions = [];
      const categoriesNums = document.getElementsByClassName("count-cat");
      const categoriesLength = categoriesNums.length;
      for (let i = 0; i < categoriesLength; i++) {
         ids.push(categoriesNums[i].parentElement.id);
         order.push(categoriesNums[i].parentElement.firstElementChild.innerText);
         //titles.push(categoriesNums[i].parentElement.querySelector(".categoryTitle").firstElementChild.value);
         //descriptions.push(categoriesNums[i].parentElement.querySelector(".categoryDescription").firstElementChild.value);
      }
      /*$.ajax({
             type: "POST",
             url: "/admin/renumerateBusinessCat",
             data: {order: order, ids:ids, titles:titles, descriptions:descriptions},
              success: function (data) {
                    location.reload();

             }
         });*/
   }
}
dragAndDrop();
</script>