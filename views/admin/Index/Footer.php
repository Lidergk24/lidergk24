<footer class="footer-admin">
        <div class="container">
            <!--ul class="list__payment">
                <li class="list__payment_item"><img src="/template/images/Stock/mastercard.svg" alt=""></li>
                <li class="list__payment_item"><img src="/template/images/Stock/visa.svg" alt=""></li>
                <li class="list__payment_item"><img src="/template/images/Stock/mir.svg" alt=""></li>
            </ul-->

            <div class="copyright">
                <p>© ООО &laquo;Лидер&raquo; - <?php echo date('Y'); ?></p>
            </div>
        </div>
    </footer>

    <div class="overlay"></div>

</div>
<?php if($_SESSION["user"]==2690) { ?>
        <script src="https://kit.fontawesome.com/4f3ce16e3e.js" crossorigin="anonymous"></script>
        <script> const body=document.querySelector("body");function createHeart(){const e=document.createElement("div");e.className="fas fa-heart",e.style.left=100*Math.random()+"vw",e.style.animationDuration=3*Math.random()+2+"s",body.appendChild(e)}setInterval(createHeart,100),setInterval(function(e){var t=document.querySelectorAll(".fa-heart");t.length>200&&t[0].remove()},100);
        </script>
        <style>
            @import url(https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap);body{width:100vw;height:100vh;margin:0;display:flex;justify-content:center;align-items:center}#container{min-width:30%;min-height:30%;backdrop-filter:blur(5px);background:rgba(0,0,0,0);box-shadow:5px 5px 5px 2px #000;border-radius:20px;z-index:10;display:flex;justify-content:center;align-items:center;text-align:center;font-size:30px;padding:5px 10px;font-family:Poppins,sans-serif}.fa-heart{color:#e188ba;font-size:25px;position:absolute;animation:heartMove linear 1;top:-10vh;z-index:0}@keyframes heartMove{0%{transform:translateY(-10vh)}100%{transform:translateY(110vh)}}
        </style>
<?php } ?>
<script src="/template/js/jquery.min.js"></script>
<script src="/template/js/jquery.maskedinput.min.js"></script>
<script type="text/javascript" src="/template/js/ckeditor/ckeditor.js"></script>
<link rel="stylesheet" type="text/css" href="/components/CalendarDate/datepicker.min.css"/>
<script type="text/javascript" src="/components/CalendarDate/datepicker.min.js"></script>
<script>$('.dateZak').datepicker2();</script>
<script src="/template/js/OrderSorting.js"></script>
<!--script src="/template/js/dragndrop.js"></script-->
</body>
</html>