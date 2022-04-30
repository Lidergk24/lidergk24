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
            <li><a title="Операторы"><span>Операторы</span></a></li>
         </ul>
         <h1>Операторы</h1>
         <div class="main-cabinet-button__group">
         </div>
         <div class="sales-table__admin managers-table table w-100">
            <div class="table__head">
               <div class="table__th managers-table__name">ФИО</div>
               <div class="table__th managers-table__phone">Телефон</div>
               <div class="table__th managers-table__phone-add">Добавочный</div>
               <div class="table__th managers-table__mail">E-mail</div>
               <div class="table__th managers-table__photo">Удалить</div>
            </div>
            <div class="table__body">
                <?php foreach($operators as $operator){ ?>
                <div class="table-body_line">
                  <div class="table__td managers-table__name">
                     <p><?php echo $operator['operator_name']; ?></p>
                  </div>
                  <div class="table__td managers-table__phone">
                     <p><?php echo $operator['operator_phone']; ?></p>
                  </div>
                  <div class="table__td managers-table__phone-add">
                     <p><?php echo $operator['operator_dob']; ?></p>
                  </div>
                  <div class="table__td managers-table__mail">
                     <p><?php echo $operator['operator_email']; ?></p>
                  </div>
                  <div class="table__td managers-table__photo">
                      <p class="idOperator" data-id="<?php echo $operator['id']; ?>">x</p>
                  </div>
                </div>
                <?php } ?>
            </div>
            <div class="table__body">
            <div class="table-body_line" id ='addOperatorForm'>
                  <div class="table__td managers-table__name">
                     <input type='text' name='name'></input>
                  </div>
                  <div class="table__td managers-table__phone">
                  <input type='text' name='phone'></input>
                  </div>
                  <div class="table__td managers-table__phone-add">
                  <input type='text' name='dob'></input>
                  </div>
                  <div class="table__td managers-table__mail">
                  <input type='text' name='email'></input>
                  </div>
                  <button class="table__td managers-table__photo">
                      <p class="OperatorAdd" style='font-weight:600; font-size:1rem'>Добавить оператора</p>
                  </button>
                   </div>
         </div>
      </div>
   </div>
</main>


<?php include ROOT . '/views/admin/Index/Footer.php'; ?>
<script>
    
    $('.idOperator').on('click', function(){
        
         var idM = $(this).closest('.idOperator').attr('data-id');
         
         var isGood= confirm('Удалить оператора?');
         
         if (isGood==true) {
             
            $.ajax({
             
                url: 'deleteOperator',
                type: 'post',
                data:{ id: idM },
                    
                    success: function(data) {
                         
                      location.reload();

                    }
            });
        }
         
    });
    $('.OperatorAdd').on('click', function(){
        
        var name =$('input[name="name"]').val();
        var phone =$('input[name="phone"]').val();
        var dob =$('input[name="dob"]').val();
        var email =$('input[name="email"]').val();

           $.ajax({
            
               url: 'addOperator',
               type: 'post',
               data:{ name: name, phone:phone, dob:dob, email:email },
                   
                   success: function(data) {
                        
                     location.reload();

                   }
           });
       
        
   });
    
</script>
