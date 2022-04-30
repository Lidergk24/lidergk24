<?php

   ob_start();
   var_dump($_GET);
   $output = ob_get_clean();
   file_put_contents('dump.txt', $output);

?>