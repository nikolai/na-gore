<?php
 function applog($msg, $level, $root="./") {
     $str = date("Y/m/d h:i:s", mktime()) . "|" .
            $level . "|" .
            $_SERVER['REQUEST_URI'] . "|" .
            $msg . "\n";
     error_log($str, 3, "{$root}logs/applog.log");
     echo(str_ireplace($str, "\n", "<br>"));
 }
 function applogSevere($msg, $root="./") {
     applog($msg, "SEVERE", $root);
 }
 function applogWarning($msg, $root="./") {
     applog($msg, "WARNING", $root);
 }
 function applogInfo($msg, $root="./") {
     applog($msg, "INFO", $root);
 }
 function applogDebug($msg, $root="./") {
     applog($msg, "DEBUG", $root);
 }
 function accesslog($msg, $root="./") {
    $level = "INFO";
    $str = date("Y/m/d h:i:s", mktime()) . "|" .
           $level . "|" .
           $_SERVER['REQUEST_URI'] . "|" .
           $_SERVER['HTTP_USER_AGENT'] . "|" .
           $msg . "\n";
    error_log($str, 3, "logs/access.log");
 }
?>
