<?php

    $stat = $_POST['stat'];
    
        if($stat=='Статистика за вчера'){
            $period = 'yesterday';
        }
        
        if($stat=='Статистика за неделю'){
            $period = '7daysAgo';
        }
        
        if($stat=='Статистика за 30 дней'){
            $period = '30daysAgo';
        }
    
            $token = 'AgAAAAAGr8RZAAaUZqQx7XaaMkcvl_ZDKZpfnhU';
             
            $params = array(
            	'ids'     => '57470944', 
            	'metrics' => 'ym:s:visits,ym:s:pageviews,ym:s:users',
            	'date1'   =>  $period, // 7daysAgo - неделя, 30daysAgo - месяц, 365daysAgo - год
                'date2'   =>  date("Y-m-d"),
            );
             
            $ch = curl_init('https://api-metrika.yandex.net/stat/v1/data/bytime?' . urldecode(http_build_query($params)));
            
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: OAuth ' . $token));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_HEADER, false);
            $res = curl_exec($ch);
            curl_close($ch);
             
            $res = json_decode($res, true);	
?>
 

                  <div class="statistics__box">
                     <p>Визиты</p>
                     <div class="statistics__box_val">
                        <?php echo $res['totals'][0][0]; ?>
                     </div>
                  </div>
                  <div class="statistics__box">
                     <p>Посетители</p>
                     <div class="statistics__box_val">
                         <?php echo $res['totals'][0][2]; ?>  
                     
                     </div>
                  </div>
                  <div class="statistics__box">
                     <p>Просмотры</p>
                     <div class="statistics__box_val">
                         <?php echo $res['totals'][0][1]; ?> 
                     </div>
                  </div>
