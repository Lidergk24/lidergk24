<?php include ROOT . '/views/admin/Index/Header.php'; ?>
<main class="main-cabinet-user main-cabinet-admin">
   <div class="container">
      <div class="cabinet-sidebar">
         <div class="btn-close__menu"></div>
         <?php include ROOT . '/views/admin/Index/Sidebar.php'; ?>
      </div>
      <div class="main-cabinet-user__content main-cabinet-admin__content">
         <h1>Кабинет администратора</h1>
         <div class="main-cabinet-admin__wrapper w-100">
            <div class="main-cabinet-admin__wrapper-left">
               <div class="table w-100 table-admin__home border-none">
                  <div class="table-admin__name">
                     <div class="table-admin__name_title">Данные системы</div>
                     <div class="table-admin__name_icon"></div>
                  </div>
                  <div class="table__body">
                     <div class="table-body_line">
                        <div class="table__td">
                           <p><strong>Всего:</strong> <?php echo $totalOrders; ?> заказов</p>
                        </div>
                        <div class="table__td">
                           <p><strong>Зарегистрировалось новых:</strong> <?php echo count($newClientsToday); ?></p>
                        </div>
                        <div class="table__td">
                           <p><strong>Всего пользователей:</strong> <?php echo count($allUsers); ?></p>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="admin-manages">
               <div class="admin-manages__title">
                  <a href="/admin/report">
                     <div class="admin-manages__name">Отчеты</div>
                  </a>
                  <a href="/admin/report">
                     <div class="admin-manages__icon"><img src="/template/images/Stock/arrow-right.png" alt="Отчеты"></div>
                  </a>
               </div>
            </div>
            <div class="dynamic-wrapper">
               <div class="dynamics-of-orders">
                  <div class="dynamics-of-orders__box">
                     <?php
                        $paramsPath = $_SERVER['DOCUMENT_ROOT'] . '/config/db_params.php';
                        $params = include($paramsPath);
                        $con = new mysqli($params['host'], $params['user'], $params['password'], $params['dbname']); 
                        
                        $date1 =  date('Y-m-d', strtotime($thisDate. " - 1 day"));
                        $date2 =  date('Y-m-d', strtotime($thisDate. " - 2 day"));
                        $date3 =  date('Y-m-d', strtotime($thisDate. " - 3 day"));
                        $date4 =  date('Y-m-d', strtotime($thisDate. " - 4 day"));
                        $date5 =  date('Y-m-d', strtotime($thisDate. " - 5 day"));
                        $date6 =  date('Y-m-d', strtotime($thisDate. " - 6 day"));
                        $date7 =  date('Y-m-d', strtotime($thisDate. " - 7 day"));
                        
                        $summ1 = mysqli_query($con, "select count(*) as cnt, sum(order_summ) as summ from product_order where date like '%$date1%'");
                        $summ1Fetch = mysqli_fetch_assoc($summ1);
                        
                        $summ2 = mysqli_query($con, "select count(*) as cnt, sum(order_summ) as summ from product_order where date like '%$date2%'");
                        $summ2Fetch = mysqli_fetch_assoc($summ2);
                        
                        $summ3 = mysqli_query($con, "select count(*) as cnt, sum(order_summ) as summ from product_order where date like '%$date3%'");
                        $summ3Fetch = mysqli_fetch_assoc($summ3);
                        
                        $summ4 = mysqli_query($con, "select count(*) as cnt, sum(order_summ) as summ from product_order where date like '%$date4%'");
                        $summ4Fetch = mysqli_fetch_assoc($summ4);
                        
                        $summ5 = mysqli_query($con, "select count(*) as cnt, sum(order_summ) as summ from product_order where date like '%$date5%'");
                        $summ5Fetch = mysqli_fetch_assoc($summ5);
                        
                        $summ6 = mysqli_query($con, "select count(*) as cnt, sum(order_summ) as summ from product_order where date like '%$date6%'");
                        $summ6Fetch = mysqli_fetch_assoc($summ6);
                        
                        
                        $summ5000 = mysqli_query($con, "select count(*) as cnt from product_order where order_summ>=5000 and order_summ <=10000");
                        $summ5000Fetch = mysqli_fetch_assoc($summ5000);
                        
                        $summ10000 = mysqli_query($con, "select count(*) as cnt from product_order where order_summ > 10000");
                        $summ10000Fetch = mysqli_fetch_assoc($summ10000);
                        
                        $summ3000 = mysqli_query($con, "select count(*) as cnt from product_order where order_summ >= 3000 and order_summ < 5000");
                        $summ3000Fetch = mysqli_fetch_assoc($summ3000);
                        
                        $summ2000 = mysqli_query($con, "select count(*) as cnt from product_order where order_summ < 3000");
                        $summ2000Fetch = mysqli_fetch_assoc($summ2000);
                        
                        
                        ?>
                     <script type="text/javascript" src="/template/js/canvasjs.min.js"></script>
                     <div id="chartContainer2" style="width: 100%; height: 300px;display: inline-block;"></div>
                  </div>
               </div>
               <div class="share-orders">
                  <div class="dynamics-of-orders__title">Доля заказов по суммам</div>
                  <div class="share-orders__box">
                     <div id="chartContainer1" style="width: 100%; height: 300px;display: inline-block;"></div>
                  </div>
               </div>
            </div>
            <div class="statistics__wrapper">
               <label class="select-admin select-admin__statistic">
                  <select name="indexStat" class="indexStat">
                     <option value="Статистика за вчера">Статистика за вчера</option>
                     <option value="Статистика за неделю">Статистика за неделю</option>
                     <option value="Статистика за 30 дней">Статистика за 30 дней</option>
                  </select>
               </label>
                <?php
                    $token = 'AgAAAAAGr8RZAAaUZqQx7XaaMkcvl_ZDKZpfnhU';
                    $params = array(
                    	'ids'     => '57470944', 
                    	'metrics' => 'ym:s:visits,ym:s:pageviews,ym:s:users',
                    	'date1'   => 'yesterday',
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
               <div class="statistics__indicators">
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
               </div>
            </div>
         </div>
         
      </div>
   </div>
</main>

<?php include ROOT . '/views/admin/Index/Footer.php'; ?>
<script>
   var chart = new CanvasJS.Chart("chartContainer1",
       {
           animationEnabled: true,
       title: {
           text: "Доля заказов по суммам"
       },
       data: [{
           type: "pie",
           startAngle: 240,
           yValueFormatString: "##0\"шт\"",
           indexLabel: "{label} {y}",
           dataPoints: [
               {y: <?php echo $summ2000Fetch['cnt']; ?>, label: "До 3000"},
               {y: <?php echo $summ5000Fetch['cnt']; ?>, label: "От 5000 до 10000"},
               {y: <?php echo $summ10000Fetch['cnt']; ?>, label: "Свыше 10000"},
               {y: <?php echo $summ3000Fetch['cnt']; ?>, label: "От 3000 до 5000"}
               
           ]
       }]
       });
   chart.render();
   
   
   
   var chart = new CanvasJS.Chart("chartContainer2",
       {
       animationEnabled: true,
       title:{
           text: "Динамика заказов"   
       },
       axisY:{
           title:"Количество заказов (сумма)"
       },
       toolTip: {
           shared: true,
           reversed: true
       },
       data: [{
           type: "stackedColumn",
           name: "Количество заказов",
           showInLegend: "true",
       //    yValueFormatString: "#,##0mn tonnes",
           dataPoints: [
               { y: <?php echo $summ1Fetch["cnt"]; ?>, label: "<?php echo $date1; ?>" },
               { y: <?php echo $summ2Fetch["cnt"]; ?>, label: "<?php echo $date2; ?>" },
               { y: <?php echo $summ3Fetch["cnt"]; ?>, label: "<?php echo $date3; ?>" },
               { y: <?php echo $summ4Fetch["cnt"]; ?>, label: "<?php echo $date4; ?>" },
               { y: <?php echo $summ5Fetch["cnt"]; ?>, label: "<?php echo $date5; ?>" },
               { y: <?php echo $summ6Fetch["cnt"]; ?>, label: "<?php echo $date6; ?>" }
           ]
       },
       {
           type: "stackedColumn",
           name: "Сумма заказов",
           showInLegend: "true",
       //    yValueFormatString: "#,##0mn tonnes",
           dataPoints: [
               { y: <?php echo round($summ1Fetch["summ"] ,2); ?> ,label: "<?php echo $date1; ?>" },
               { y: <?php echo round($summ2Fetch["summ"] ,2); ?>, label: "<?php echo $date2; ?>" },
               { y: <?php echo round($summ3Fetch["summ"] ,2); ?>, label: "<?php echo $date3; ?>" },
               { y: <?php echo round($summ4Fetch["summ"] ,2); ?>, label: "<?php echo $date4; ?>" },
               { y: <?php echo round($summ5Fetch["summ"] ,2); ?>, label: "<?php echo $date5; ?>" },
               { y: <?php echo round($summ6Fetch["summ"] ,2); ?>, label: "<?php echo $date6; ?>" }
           ]
       }]
       });
   chart.render();
   
   
   
   $(document).on('change', '.indexStat', function(){
      var indexVal = $('.indexStat').val();
      $.ajax({
             type: "POST",
             url: "/components/ajaxRequest/adminStat.php",
             data: { stat: indexVal},
             success: function (data) {
                 $('.statistics__indicators').html(data);
             }
         });
     
   });
</script>
<!-- 
<div class="table-body">
   <div class="table-body__line">
      <div class="number-order">
         <h6 class="box-mobile">Заказов за вчера</h6>
         <p><?php echo $countOrdersYesterday; ?></p>
      </div>
      <div class="date-order">
         <h6 class="box-mobile">Заказов сегодня</h6>
         <p><?php echo $countOrdersToday; ?> </p>
      </div>
      <div class="sum-order">
         <h6 class="box-mobile">Заказов за неделю</h6>
         <p><?php echo $countOrdersWeek->num_rows; ?></p>
      </div>
      <div class="quantity-order">
         <h6 class="box-mobile">Сумма заказов за сегодня</h6>
         <p><?php echo round($SummOrdersToday, 2); ?> ₽</p>
      </div>
      <div class="repeat-order">
         <h6 class="box-mobile">Общая сумма заказов </h6>
         <p><?php echo round($AllSummOrders,2); ?> ₽</p>
      </div>
   </div>
</div>
</div>
</div>