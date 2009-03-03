<?php
    $story_path = $_GET["s"];
    $story_full_path = "articles/$story_path".".php";
    //echo ("story_path arg = $story_path<br>");
    //echo ("story_full_path = $story_full_path<br>");
    
    ob_start();
       include("$story_full_path");
       $includedphp = ob_get_contents();
    ob_end_clean();

    echo $includedphp;
?>