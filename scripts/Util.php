<?php
/**
 * Created on 09.03.2009 0:17:29
 * @author nikolai
 */

function cutNewLine($line) {
    // for win
    $result = str_ireplace("\r\n", "", $line);
    // for unix
    $result = str_ireplace("\n", "", $result);
    return $result;
}
?>
