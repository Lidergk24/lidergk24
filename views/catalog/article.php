<?php  include ROOT . '/views/layouts/header.php'; 
 $environment = include_once($_SERVER['DOCUMENT_ROOT'] . '/config/environment.php'); ?>
<div class="breadcrumb-wrapper">
   <div class="container">
      <ul class="breadcrumb">
        <li><a href="/" title="Главная"><span>ГЛАВНАЯ</span></a></li>
        <li><a><span>Статьи</span></a></li>
      </ul>
   </div>
</div>
<section class="news">
   <div class="container">
      <h1>Новости</h1>
      <div class="box-text w-100 mb-30">
      </div>
      <div class="news__wrapper w-100 d-flex align-items-stretch">
            <?php foreach ($aticle as $articleArray){ 
             $mbsubstrName = mb_substr($articleArray['article_text'],0,100)."...";
            ?>
         <div class="news__item news__item_block">
            
            <div class="news__item_img"><img src="/upload/images/<?php echo $articleArray['article_image']; ?>" alt="<?php echo $articleArray['article_name']; ?>"></div>
            <div class="news__item_body">
               <div class="news__item_title"><?php echo $articleArray['article_name']; ?></div>
               <div class="news__item_text">
                  <p><?php echo $mbsubstrName; ?></p>
               </div>
               <a href="/art/<?php echo $articleArray['article_slug']; ?>" class="links color_blue text-uppercase" title="">Читать дальше...</a>
            </div>
         </div>
         <?php } ?>
      </div>
   </div>
</section>

<?php  include ROOT . '/views/layouts/footer.php'; ?>
<script>
    
    var i = 6;

    $(document).ready(function(){ 
        
        var $element = $('.subscribe');

        $(window).scroll(function() {
            
          var scroll = $(window).scrollTop() + $(window).height();
          var offset = $element.offset().top
          
          if (scroll > offset) {
            
            $.ajax({
                        type: 'post',
                        url: "/components/articleLoad.php", 
                        data: { count: 6, begin: i+=6 },
                        success: function(data) {
                           
                           $(".news__wrapper").append(data);
                           
                        }
                    
                    }); 
          }
          
        });
    });
</script>