<?php include ROOT . '/views/admin/Index/Header.php'; 
$environment = include_once($_SERVER['DOCUMENT_ROOT'] . '/config/environment.php');
?>
<main class="main-cabinet-user main-cabinet-user-view main-cabinet-admin">
   <div class="container">
      <div class="cabinet-sidebar">
         <div class="btn-close__menu"></div>
         <?php include ROOT . '/views/admin/Index/Sidebar.php'; ?>
      </div>
      <div class="main-cabinet-user__content main-cabinet-admin__content">
         <ul class="breadcrumb breadcrumb-cabinet">
            <li><a href="/admin" title="Главная"><span>ГЛАВНАЯ</span></a></li>
            <li><a href="/admin/fids" title="Фиды"><span>фиды</span></a></li>
            <li><a title="Добавить фид"><span>Добавить фид</span></a></li>
         </ul>
         <h1>Добавить фид</h1>
         <form enctype="multipart/form-data" method="POST" class="form-add-file form-admin-cabinet form-add-article">
            <div class="form-group">
               <label>
               <span class="form-group__title">Товар</span>
               <input type="text" id="product-name" name="product_name" autocomplete="off" required>
                 <div class="form-search__result"></div>
               </label>
            </div>
            <div name="pcode"></div>
            <button class="btn btn_black" name="submit" id="generate" type="submit">Сгенерировать фид</button>
         </form>
         <div id="changed-pos"></div>
         <button class="btn btn_black" id="set-fid"></button>
         <div id="download-fid">
            
         </div>
      </div>
   </div>
</main>

<?php include ROOT . '/views/admin/Index/Footer.php'; ?>
<script>
    const fidGenerate = (prod_code) => 
    {
        //alert(prod_code);
        $.ajax({
            type: 'post',
            url: '/admin/searchproduct',
            data: { prod_code: prod_code },
            dataType: 'TEXT',
            success: function(data) {
               //return '1';
            },
            error: function(data) {
                //return 2;
            }
        });
    };

    $('#product-name').keyup(function(e) {
        
    var searchItems = $(this).val();
        e.preventDefault();
        e.stopPropagation();
        //if (searchItems.trim().length > 2) {
         
            $.ajax({
                type: 'post',
                url: "/views/admin/Rules/SearchItemEx.php",
                data: {
                    searchItem: searchItems.trim()
                },
                dataType: 'TEXT',
                success: function(data) {
                    $('.form-search__result').css('position', 'relative');
                    $(".form-search__result").html(data).fadeIn();
                    $(".line").click(function(){
                         let fid_stat = $(this).closest('.line').find('.code_search_ajax');
                         let stat = fid_stat.data('status');
                         if(stat == '2') {
                            var line = $(this).closest('.line').find('.code_search_ajax').html();
                             var lineReplace = line.substr(15);
                             $(this).val(lineReplace);
                             $(".form-search__result").fadeOut("slow");
                             $('[name=pcode]').data( "prodcode", lineReplace );
                             let pcode = $('[name=pcode]').data("prodcode");
                             $('#generate').show();
                             $('#changed-pos').data('parse', 'cat').show().text(lineReplace); 
                             localStorage.setItem('ptype', $('#changed-pos').data('parse'));
                         } else if (stat == '1') {
                             var line = $(this).closest('.line').find('.code_search_ajax').html();
                             var lineReplace = line.replace(/[^0-9-]/gi, '');
                             $(this).val(lineReplace);
                             $(".form-search__result").fadeOut("slow");
                             $('[name=pcode]').data( "prodcode", lineReplace );
                             let pcode = $('[name=pcode]').data("prodcode");
                             $('#generate').show();
                             $('#changed-pos').data('parse', 'prod').show().text(lineReplace); 
                             localStorage.setItem('ptype', $('#changed-pos').data('parse'));
                         } else if (stat == '3') {
                             var line = $(this).closest('.line').find('.code_search_ajax').html();
                             $(this).val(lineReplace);
                             $(".form-search__result").fadeOut("slow");
                             $('#generate').show();
                             $('#changed-pos').data('parse', 'all').show().text('Весь каталог'); 
                             localStorage.setItem('ptype', $('#changed-pos').data('parse'));
                         }
                         //let w = fidGenerate(lineReplace);
                         //window.location.href = "/admin/allfids";
                    });
                }
            }); 
        //} 
    });
    $('#generate').on('click', function(e) {
        e.preventDefault();
        $('#product-name').val('');
        let pcode = $('[name=pcode]').data("prodcode");
        let ptype = localStorage.getItem('ptype');
        if(ptype === 'prod') {
            $.ajax({
                type: 'post',
                url: '/admin/addfid',
                data: {
                    prod_code: pcode, parse_type: ptype
                },
                dataType: 'TEXT',
                success: function(data) {
                    alert('Фид добавлен!');  
                    $('#download-fid').show().empty().append('<a href="/upload/fids/fid__'+pcode+'.yml" download>Скачать фид</a>');
                    $('#set-fid').trigger('click');
                }
            });
        }
        else if(ptype === 'cat') {
            $.ajax({
                type: 'post',
                url: '/admin/addCatfid',
                data: {
                    prod_code: pcode, parse_type: ptype
                },
                dataType: 'TEXT',
                success: function(data) {
                    alert('Фид категории добавлен!');  
                    $('#download-fid').show().empty().append('<a href="/upload/fids/fid__'+pcode+'.yml" download>Скачать фид</a>');
                    $('#set-fid').trigger('click');
                }
            });
        }
        else if(ptype === 'all') {
            $.ajax({
                type: 'post',
                url: '/admin/addAllfid',
                data: {
                    parse_type: ptype
                },
                dataType: 'TEXT',
                success: function(data) {
                    alert('Фид категории добавлен!');  
                    $('#download-fid').show().empty().append('<a href="/upload/fids/fid__all.yml" download>Скачать фид</a>');
                    $('#set-fid').trigger('click');
                }
            });
        }
    });
    
    $('#set-fid').on('click', function(e) {
        e.preventDefault();
        $.ajax({
            type: 'post',
            url: '/components/fidDownload.php',
            data: {
                prod_code: $('[name=pcode]').data("prodcode"), parse_type: $('#changed-pos').data('parse')
            },
            dataType: 'TEXT',
            success: function(data) {
                console.log(data);    
            }
        });
    });
    
    $('#download-fid').on('click', function(e) {
        //e.preventDefault();
        e.stopPropagation();
        $(this).html('');
        $('#changed-pos').html('');
    });
/*    $(document).ready(function() {
        $('#product-name').on('input', function(e){
            e.preventDefault();
            let subStr = $(this).val().length;
            let search = $(this).val();
            if(subStr >= 3) {
                $.ajax({
                   type: 'post',
                   url: "/admin/searchproduct", 
                   data: { search: search },
                   dataType: 'text',
                   success: function(datastring){
                       let productData = $.parseJSON(datastring);
                       let productList = '';
                       /*$(productData).each(function(index, val){
                          productList += '<option data-product-id='+val['id']+'>'+val['product_name']+'<option>';  
                       });
                       $('#products-searched').show();
                       $('#products-searched select').append(productList);*/
                   /*}
                }) 
            }
        });
    });*/
</script>