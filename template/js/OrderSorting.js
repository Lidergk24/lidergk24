$('.search').keyup(function() {

    $('[name=search]').bind("change keyup input click", function() {
        if (this.value.match(/[^0-9]/g)) {
            this.value = this.value.replace(/[^0-9]/g, '');
        }
    });

    var searchVal = $('input[name=search]').val();
    if (searchVal.length > 3) {

        $.ajax({
            type: 'post',
            url: "/components/ajaxRequest/searchOrder.php",
            data: {
                search: searchVal
            },
            dataType: 'TEXT',
            success: function(data) {

                $(".table-orders").html(data);
            }
        })

    }
});


$('.datepicker2--footer').click(function() {

    $('.datepicker2').hide();
    $('.dateZak').click(function() {
        $('.datepicker2').show();
    });
    var dataSort = $('.dateZak').val();
    $.ajax({
        type: 'post',
        url: "/components/ajaxRequest/sortOrderByDate.php",
        data: {
            dataS: dataSort
        },
        dataType: 'TEXT',
        success: function(data) {

            $(".table-orders").html(data);

        }
    });
});



function selectOperator() {
    var selectOperator = $(this).closest('.table-orders__manager_box').find('.selOperator').val();
    var selectManagerS = $(this).closest('.table-orders__manager_box').find('.selOperator');
    var order_numberClient = $(this).closest('.table-body_line').find('.table-orders__number p:eq(0)').html();
    var numberClient = $(this).closest('.table-body_line').find('.table-orders__phone p').html();
    $.ajax({
        type: 'post',
        url: "/components/ajaxRequest/operatorBase.php",
        data: {
            operator: selectOperator,
            order_number: parseFloat(order_numberClient),
            phone: numberClient
        },
        dataType: 'TEXT',
        success: function(data) {

            selectManagerS.after('<p class="hide_vis_confirm" style="color:red;">' + data + '</p>');
            setTimeout(function() {
                $(".hide_vis_confirm").slideUp();
            }, 2000);
        }
    })
}

$('.selOperator').change(selectOperator);


function sortOperator() {

    var sortOperator = $('.sortOperator').val();

    if (sortOperator == 'По оператору') {
        location.reload();
    }
    $.ajax({
        type: 'post',
        url: "/components/ajaxRequest/sortOperator.php",
        data: {
            operator: sortOperator
        },
        dataType: 'TEXT',
        success: function(data) {

            $(".table-orders").html(data);
        }
    })
}

$('.sortOperator').change(sortOperator);


function sortByStatus() {
    var sortByStatus = $('.sortByStatus').val();

    if (sortByStatus == 'По статусу') {
        location.reload();
    }
    $.ajax({
        type: 'post',
        url: "/components/ajaxRequest/sortByStatus.php",
        data: {
            sortStatus: sortByStatus
        },
        dataType: 'TEXT',
        success: function(data) {

            $(".table-orders").html(data);
        }
    })
}

$('.sortByStatus').change(sortByStatus);

function updateManager() {
    var selectUpdateManager = $(this).closest('.table-orders__manager').find('.manager-select').val();
    var order_numberUpdateClient = $(this).closest('.table-body_line').find('.table-orders__number p:eq(0)').html();
    var selectstatS = $(this).closest('.table-body_line').find('.manager-select');
    var phonesMan = $(this).closest('.table-body_line').find('.table-orders__phone p').html();
    //	alert(phonesMan);
    $.ajax({

        type: 'post',
        url: "/components/ajaxRequest/operatorBase.php",
        data: {
            manager: selectUpdateManager,
            order_numberManager: parseFloat(order_numberUpdateClient),
            phone: phonesMan
        },
        dataType: 'TEXT',
        success: function(data) {
            selectstatS.after('<p class="hide_vis_confirm" style="color:green;">' + data + '</p>');
            setTimeout(function() {
                $(".hide_vis_confirm").slideUp(2000);
            });
        }
    })
}
$('.manager-select').change(updateManager);


$('.comment_operator').blur(function() {
    var comment_operator = $(this).closest('.table-body_line').find('.comment_operator').val();
    var order_number = $(this).closest('.table-body_line').find('.table-orders__number p:eq(0)').html();
    $.ajax({
        type: 'post',
        url: "/components/ajaxRequest/operatorBase.php",
        data: {
            comment: comment_operator,
            nomer: parseFloat(order_number)
        },
        dataType: 'TEXT',
    })
});

$('.status-select').change(function() {
    var selectstat = $(this).closest('.table-orders__status').find('.status-select').val();
    var numberClientOrder = $(this).closest('.table-body_line').find('.table-orders__number p:eq(0)').html();
    var selectstatS = $(this).closest('.table-body_line').find('.status-select');
    var colors = $(this).closest('.table-orders__status').find('.status-select option:selected').attr("data-color");
    $.ajax({
        type: 'post',
        url: "/components/ajaxRequest/operatorBase.php",
        data: {
            status: selectstat,
            order_num: parseFloat(numberClientOrder),
            color: colors,
        },
        dataType: 'TEXT',
        success: function(data) {
            selectstatS.after('<p class="hide_vis_confirm" style="color:green;">' + data + '</p>');
            setTimeout(function() {
                $(".hide_vis_confirm").slideUp();
            }, 2000);
        }
    })

});

// $('.status-select').on('change', function(){
//       // alert(123);
//     	var selectstat = $(this).closest('.table-orders__status').find('.status-select').val();
// 	var numberClientOrder = $(this).closest('.table-body_line').find('.table-orders__number p:eq(0)').html();
// 	var selectstatS = $(this).closest('.table-body_line').find('.status-select');
// 	$.ajax({
// 		type: 'post',
// 		url: "http://liderzm5.bget.ru/components/ajaxRequest/operatorBase.php",
// 		data: {
// 			status: selectstat,
// 			order_num: parseFloat(numberClientOrder)
// 		},
// 		dataType: 'TEXT',
// 		success: function(data) {
// 			selectstatS.after('<p class="hide_vis_confirm" style="color:green;">' + data + '</p>');
// 			setTimeout(function() {
// 				$(".hide_vis_confirm").slideUp();
// 			}, 2000);
// 		}
// 	})
// });

//////////////////////////

//$('.status-select').change(selectStatus);

/* $('.form_button').click(function(e){
    
    e.preventDefault()
     var operatorBase = $('.dateZak').val();
     if(operatorBase==''){
    
        alert('При сложной сортировке необходимо выбирать дату! Иначе система попросту не поймет о чем речь.');
        
     }   else {
        
            var $data = {};
            
            $('.zak_form').find('input, select').each(function() {
                
               $data[this.name] = $(this).val();
              
            });
            
             $.ajax({
                  url: 'https://lider-gk24.ru/components/ajaxRequest/GlobalOrderSearch.php',
                  type: 'post',
                  data: $data,
                   success: function(result) {
                     // $(".table-history").html(data); 
                   }
             });
         }
 }); */