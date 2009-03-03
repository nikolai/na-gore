   <?php
     function foo($msg)
     {
         echo "var=".$msg;
     }
     $docroot = $_SERVER['DOCUMENT_ROOT'];
     $cur_dir = getcwd();
     echo ("document root = ".$docroot."<br>");
     echo ("current dir = ".$cur_dir."<br>");
     echo ("clash = "."/"."<br>");
     
     echo("<a href='../articles.php?art=2009/1/osipov_duhov'>Осипов</a><br>");
   ?>
   
   