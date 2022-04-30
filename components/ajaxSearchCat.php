<?php
// Подключение файлов системы
define('ROOT', dirname(__FILE__)."/../");
require_once(ROOT.'/components/Autoload.php');


$con = Db::getConnectionMysqli();

$search = $_POST['search'];
$count = $_POST['count'];
$begin = $_POST['begin'];
//Илья сказал, что продукты из категории под заказ должны быть полностью исключены с сайта, но я оставляю комментарии чтобы их можно было вернуть позже
//$sqlForSearch = "select * from (SELECT * FROM Product P UNION SELECT * FROM ProductCustom C) as PC WHERE product_part_number like '%$search%' and product_price > 0  order by id ASC LIMIT $begin, $count";
$sqlForSearch = "select * from Product as PC WHERE product_part_number like '%$search%' and product_price > 0  order by id ASC LIMIT $begin, $count";
     $query = mysqli_query($con,$sqlForSearch);
     foreach ($query as $ajaxitem) {

     		$ajaxitem['product_price'] = Special::getUserPrice($ajaxitem);
     
                $thisItemDate =  date("Y-m-d",strtotime($ajaxitem['product_date'])); 
                                    $date_1 = date("Y-m-d");
                                    $date_2 = $thisItemDate;
                                    $date_timestamp_1 = strtotime($date_1);
                                    $date_timestamp_2 = strtotime($date_2);
                                    $diff = $date_timestamp_1 - $date_timestamp_2; 
                                    $diff = abs($diff);
                                    $diff_day = intval($diff / (3600 * 24));
                if($diff_day<5){
                ?>
            <div class="product-box">
               <?php if($ajaxitem['product_warehouse']>0) { ?>
               <div class="availability in-stock">В наличии</div>
               <?php } else { ?>
               <div class="availability not-stock">Нет в наличии</div>
               <?php } ?>
               <a href="/product/<?php echo $ajaxitem['product_part_number']; ?>" class="product-box__image">
                    <?php 
                        foreach (json_decode($ajaxitem['product_image']) as $imagesCategory) {
                            foreach (array($imagesCategory) as $oneImagescategory) { ?>
                                    <img src="/upload/<?php echo $oneImagescategory->{0}; ?>" alt="<?php echo $ajaxitem['product_name']; ?>">
                    <?php } } ?>
               </a>
               <div class="product-box__info">
                  <a href="/product/<?php echo $ajaxitem['product_part_number']; ?>" class="name"><?php echo $ajaxitem['product_name']; ?></a>
                  <div class="size">КОД: <?php echo $ajaxitem['product_part_number']; ?></div>
               </div>
               <!--  <ul class="list-val">
                 <li class="price_one" data-price_one="<?php echo $ajaxitem['product_price']; ?>">За шт</li>
                 <li class="price_pak" data-price_pak="<?php echo $ajaxitem['miz_zakaz']*$ajaxitem['product_price']; ?>">За упаковку</li>
                              </ul> -->
              
               <div class="list-quantity">
                  <?php foreach (array($ajaxitem["product_atributs"]) as $productAtributItem) {
                                    $oneAtribut = explode(";" , $productAtributItem);
                                    $oneAtributUnique = array_unique($oneAtribut);
                                         foreach ($oneAtributUnique as $oneOne) {
                                            $svoistvaOne = explode(":", $oneOne);
                                            $svoistvaOnes = $svoistvaOne[1];
                                            $productAtributView = mysqli_query($con, "SELECT * from Product_atributs where atributId='$svoistvaOnes'");
                                                foreach ($productAtributView as $onesOnesAtribut) { 
                                                    if ($onesOnesAtribut["atributTitle"]=='Количество в коробке, шт') {
                                                        $kol_pack = $onesOnesAtribut['atributValue']; ?>
                                                         
                                                         <p>В коробке: <span class="red"><?php echo $kol_pack; ?> шт</span></p>
                                                    <?php }
                                                    if ($onesOnesAtribut["atributTitle"]=='Количество в упаковке, шт') {
                                                        $kol_upak = $onesOnesAtribut['atributValue']; ?>
                                                         
                                                        <p>В упаковке: <span class="red"><?php echo $kol_upak; ?> шт</span></p>
                                                   <?php } ?>
                            
                  
                  <?php } } } ?>
               </div>
               <div class="product-box__info-bottom">
                  <div class="price-wrapper">
                     <div class="new-price red"><?php echo $ajaxitem['product_price']; ?> <i class="fas fa-ruble-sign"></i></div>
                  </div>
                   <div class="amount">
                     <div class="down" data-order="<?php echo $ajaxitem['miz_zakaz']; ?>">-</div>
                     <input type="text" name="count_product" value="<?php echo $ajaxitem['miz_zakaz']; ?>" maxlength="5" <?php if($ajaxitem['miz_zakaz']>1){ echo "readonly='readonly'"; } ?>/>
                     <div class="up" data-order="<?php echo $ajaxitem['miz_zakaz']; ?>">+</div>
                  </div>
                  <a href="#" data-id="<?php echo $ajaxitem['id']; ?>" data-product_count="" class="add-cart">
                     <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="510px" height="510px" viewBox="0 0 510 510" style="enable-background:new 0 0 510 510;" xml:space="preserve">
                        <g>
                           <g>
                              <path d="M153,408c-28.05,0-51,22.95-51,51s22.95,51,51,51s51-22.95,51-51S181.05,408,153,408z M0,0v51h51l91.8,193.8L107.1,306
                                 c-2.55,7.65-5.1,17.85-5.1,25.5c0,28.05,22.95,51,51,51h306v-51H163.2c-2.55,0-5.1-2.55-5.1-5.1v-2.551l22.95-43.35h188.7
                                 c20.4,0,35.7-10.2,43.35-25.5L504.9,89.25c5.1-5.1,5.1-7.65,5.1-12.75c0-15.3-10.2-25.5-25.5-25.5H107.1L84.15,0H0z M408,408
                                 c-28.05,0-51,22.95-51,51s22.95,51,51,51s51-22.95,51-51S436.05,408,408,408z"></path>
                           </g>
                        </g>
                     </svg>
                  </a>
               </div>
            </div>
     
<?php } } ?>
<script>
    $('.price_one').click(function(){
            $(this).closest('.product-box').find('.price_pak').removeClass('active');
            $(this).closest('.product-box').find('.price_one').addClass('active');
        var price_one = $(this).closest('.product-box').find('.price_one').data('price_one');
        $(this).closest('.product-box').find('.new-price').html(price_one+' <i class="fas fa-ruble-sign"></i>');
    });
    
    $('.price_pak').click(function(){
            $(this).closest('.product-box').find('.price_one').removeClass('active');
            $(this).closest('.product-box').find('.price_pak').addClass('active');
        var price_pak = $(this).closest('.product-box').find('.price_pak').data('price_pak');
        $(this).closest('.product-box').find('.new-price').html(price_pak+' <i class="fas fa-ruble-sign"></i>');
    });
    
    $('.add-cart').click(function(){
         var count_product = $(this).closest('.product-box__info-bottom').find('input[name=count_product]').val();
         var itogg = $(this).closest('.product-box__info-bottom').find('.add-cart').attr('data-product_count', count_product);
    });
    
    $(document).ready(function() {

    $(".up").on("click", function(e) {
        e.preventDefault();
        var a = $(this).data("order"),
            i = $(this).parent(),
            t = $(i).find("input"),
            n = t.val();
        if (void 0 !== a && "" != a && 1 != a) {
            var o = 1 * n + 1 * a;
            t.val(o)
        } else t.val(++n)
    }), $(".down").on("click", function(e) {
        e.preventDefault();
        var a = $(this).parent(),
            i = $(this).data("order"),
            t = $(a).find("input"),
            n = t.val();
        if (void 0 !== i && "" != i && 1 != i) {
            var o = 1 * n - 1 * i;
            n > 1 * i && t.val(o)
        } else n > 1 && t.val(--n)
    })
    });
    
    
    $(document).ready(function(){

	$(".add-cart").click(function () {
		var id = $(this).attr("data-id");
		var count_product = $(this).attr("data-product_count");
		cart_add_ajax (id, count_product);	// Добавляем товар в корзину
		return false;
	});
    });

	
	$('.add-cart').click(function(){
	        $('.avcc').css('display','block');
	        $(this).closest('.product-box__info-bottom').find('.add-cart').addClass('btn-disabled');
	        $(this).closest('.product-box__info-bottom').find('.add-cart').addClass('add-cart_two');
	        var block_count_cart = $(this).closest('.product-box__info-bottom').find('.amount').addClass('block_count_cart');
	});

	$('.close_add_cart').click(function(){
	        $('.avcc').slideToggle("slow")
	});
	$('.close_add_cart_button').click(function(){
		$('.avcc').slideToggle("slow")
	});

        
</script>