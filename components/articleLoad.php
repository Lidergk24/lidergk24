<?php

$db = Db::getConnection();

$result = $db->prepare($sql);

$count = $_POST['count'];
$begin = $_POST['begin'];
$environment = include_once($_SERVER['DOCUMENT_ROOT'] . '/config/environment.php');
$sql = 'select * from article order by ID DESC LIMIT :count  OFFSET :begin';
$result = $db->prepare($sql);
$result->bindParam(':count', $count, PDO::PARAM_STR);
$result->bindParam(':begin', $begin, PDO::PARAM_STR);
$result->execute();
$res = $result->fetch();
     foreach ($res as $ajaxitem) { 
        $mbsubstrName = mb_substr($ajaxitem['article_text'],0,100)."..."; ?>
            
            <div class="news__item news__item_block">
            <div class="news__item_img"><img src="<?php  echo $environment["base_url"]; ?>/upload/images/<?php echo $ajaxitem['article_image']; ?>" alt="<?php echo $ajaxitem['article_name']; ?>"></div>
            <div class="news__item_body">
               <div class="news__item_title"><?php echo $ajaxitem['article_name']; ?></div>
               <div class="news__item_text">
                  <p><?php echo $mbsubstrName; ?></p>
               </div>
               <a href="/art/<?php echo $ajaxitem['article_slug']; ?>" class="links color_blue text-uppercase" title="">Читать дальше...</a>
            </div>
         </div>
     
<?php } ?>
 