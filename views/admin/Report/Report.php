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
            <li><a title="Формирование отчетов"><span>Формирование отчетов</span></a></li>
         </ul>
         <h1>Формирование и просмотр отчетов</h1>
         <form enctype="multipart/form-data" method="POST" class="form-add-file form-admin-cabinet form-add-article">
            <div class="form-group">
                <label>
                <span class="form-group__title">Название статьи</span>
                <input type="text" data-range="true" data-multiple-dates-separator=" - " placeholder="Поиск по дате" class="datepicker2-here dateZak"/>
                
                <script>
                    $('.dateZak').datepicker2();
                  </script>
                </label>
                <p class="datePickerAjax">Выберите дату чтобы получить отчет</p>
            </div>
         </form>
      </div>
   </div>
</main>

<?php include ROOT . '/views/admin/Index/Footer.php'; ?>
<script>
   $('.datepicker2--footer').click(function(){
     $('.datepicker2').hide(); 
     $('.dateZak').click(function(){
         $('.datepicker2').show(); 
     });
   var dataSort = $('.dateZak').val();
   $.ajax({
        type: 'post',
        url: "/components/ajaxRequest/report.php", 
        data: { dataS: dataSort },
        dataType: 'TEXT',
         success: function(data){
           $(".datePickerAjax").html(data); 
         }
     }); 
   });
</script> 