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
            <li><a><span>Загрузить прайс лист</span></a></li>
         </ul>
         <form enctype="multipart/form-data" method="POST" class="form-add-file form-admin-cabinet">
            <div class="file-upp__wrapper">
               <label class="file-upp">
               <span class="icon-plus">
               <img src="images/plus.svg" alt="">
               </span>
               <span class="file-upp-name">Выберите файл</span>
               <input id="price" type="file" name="filename">
               </label>
               <progress id="progressbar" value="0" max="100"></progress>
               <div class="js-value">Файл не выбран</div>
            </div>
            <div class="goodUpdatePrice"></div>
            <p id="upload" class="btn btn_black">Загрузить прайс</p>
         </form>
         <div class="form-group__title">Загрузка цен для главной страницы (на скачивание)
         <form class="price-main-page box-text-no-show">
            <span class="file-upp-name">Выберите файл</span>
            <input id="pricesForMainPage" type="file" name="filename">
         </form>
         </div>
      </div>
   </div>
</main>

<?php include ROOT . '/views/admin/Index/Footer.php'; ?>
<script>

$('#price').change(function(){
    
    $('#upload').css('display', 'block');
    
}); 

    $('#upload').on('click', function() {
    var progressBar = $('#progressbar');
    $('#progressbar').css('display', 'block');
    var file_data = $('#price').prop('files')[0];
    var form_data = new FormData();
    form_data.append('file', file_data);

    $.ajax({
                url: '/views/admin/Price/updatePriceList.php',
                dataType: 'text',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'post',
                xhr: function(){
        var xhr = $.ajaxSettings.xhr(); // получаем объект XMLHttpRequest
        xhr.upload.addEventListener('progress', function(evt){ // добавляем обработчик события progress (onprogress)
          if(evt.lengthComputable) { // если известно количество байт
            // высчитываем процент загруженного
            var percentComplete = Math.ceil(evt.loaded / evt.total * 100);
            // устанавливаем значение в атрибут value тега <progress>
            // и это же значение альтернативным текстом для браузеров, не поддерживающих <progress>
            progressBar.val(percentComplete).text('Загружено ' + percentComplete + '%');
          }
        }, false);
        return xhr;
      },
                success: function(data){
                    
                    if ( data=='success' ) {
                        
                        $('.goodUpdatePrice').css('display', 'block');
                        $('.goodUpdatePrice').html('Прайс лист успешно загружен');
                        
                            setTimeout ( function() {
                                
                                location.reload();
                                
                            }, 2500);
                        
                    } 
                    
                }
     });
});    
    
</script>
<style>
#progressbar{
    display: none;
}
    ::-webkit-progress-bar {
  background: white;
}
::-webkit-progress-value {
  background: #3a9289;
}
::-moz-progress-bar {
  background: #3a9289;
}
progress {
  color: #3a9289;
  background: white;
  border: 2px solid #3a9289;
  border-radius: 5px;
}
</style>