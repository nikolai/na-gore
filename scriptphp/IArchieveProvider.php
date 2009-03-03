<?php
/**
 * IArchieveProvider
 * @author HauBHbIE
 */
interface IArchieveProvider {
    function getYears();
    function getMonths($year);
    function getLinks($year, $month);
}
?>
