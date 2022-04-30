<?php

$paramsPath = $_SERVER['DOCUMENT_ROOT'] . '/config/db_params.php';
$params = include($paramsPath);
$con = new mysqli($params['host'], $params['user'], $params['password'], $params['dbname']);  
   
   if (isset($_POST['search'])) {
       
       $ajax = $_POST['search'];
       $query = mysqli_query($con, "SELECT * from user_ur where ur_profile like '%$ajax%' or ur_phone like '%$ajax%' or ur_email like '%$ajax%' limit 5");
           if ($query->num_rows > 0) { 
                 foreach ($query as $searchResult){ ?>
                <div class="table-body_line">
                                <div class="table__td info-orders__table_profile">
                                    <a class="color_blue" title="<?php echo $searchResult['ur_profile']; ?>" href="/admin/ordprof/<?php echo $searchResult['fiz_phone']; echo $searchResult['ur_phone']; ?>"><?php echo $searchResult['fiz_fio']; ?><?php echo $searchResult['ur_profile']; ?></a>
                                </div>
                                <div class="table__td info-orders__table_requisites">
                                    <p><?php if(isset($searchResult['ur_inn'])){ echo 'ИНН: '.$searchResult['ur_inn']; } ?></p>
                                   <p><?php if(isset($searchResult['ur_company'])){ echo 'Организация: '.$searchResult['ur_company']; } ?></p>
                                   <p><?php if(isset($searchResult['ur_kpp'])){ echo 'КПП: '.$searchResult['ur_kpp']; } ?></p>
                                   <p><?php if(isset($searchResult['ur_bik'])){ echo 'БИК: '.$searchResult['ur_bik']; } ?></p>
                                   <p><?php if(isset($searchResult['ur_rs'])){ echo 'Р/С: '.$searchResult['ur_rs']; } ?></p>
                                   <p><?php echo $searchResult['fiz_email']; ?></p>
                                </div>
                                <div class="table__td info-orders__table_full-name">
                                    <p><?php echo $searchResult['ur_contact']; ?></p>
                        <p><?php echo $searchResult['fiz_email']; ?></p>
                                </div>
                                <div class="table__td info-orders__table_address-pay">
                                   <p><?php echo $searchResult['ur_adress']; ?></p>
                        <p><?php echo $searchResult['fiz_adress']; ?></p>
                                </div>
                                <div class="table__td info-orders__table_contacts">
                                    <p><?php echo $searchResult['ur_email']; ?></p>
                        <p><?php echo $searchResult['ur_phone']; ?></p>
                                </div>
                            </div>
        <?php }  } else {
        
        echo "Не удалось найти ничего :(";
        }
        ?>
<?php } ?>  
