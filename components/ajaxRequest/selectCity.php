<?php
$paramsPath = $_SERVER['DOCUMENT_ROOT'] . '/config/db_params.php';
$params = include($paramsPath);
$con = new mysqli($params['host'], $params['user'], $params['password'], $params['dbname']); 
   
    if (isset($_POST['city'])) {

        $ajax = $_POST['city'];
        $query = mysqli_query($con, "SELECT name from geo_city where name like '%$ajax%' and name !='Москва' and name !='Санкт-Петербург' order by name limit 5");
       if ($query->num_rows>0) { ?>
       <div class="line">
                        <div class="title_search_ajax">Москва</div>
                        
                    </div>
                     <div class="line">
                        <div class="title_search_ajax">Санкт-Петербург</div>
                        
                    </div>
      <?php  foreach ($query as $searchResult) { ?>
               
                
                
                    <div class="line">
                        <div class="title_search_ajax"><?php echo $searchResult['name']; ?></div>
                        
                    </div>
                <?php } ?>
               
               <?php } else{ ?>   
<div class="line">ничего не найдено</div>
      
   
   <?php } } ?>
   
  