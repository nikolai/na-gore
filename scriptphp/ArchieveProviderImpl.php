<?php
/**
 * Description of ArchieveProviderImpl
 * Need logging.php to be included.
 * @author HauBHbIE
 */

// class contains all info needed to display on archieve page
class ArchieveEntry {
    var $link, $title, $author, $pubdate;
}

//class ArchieveModel {
//    var $modelYears;
//}
//
//class ModelYear {
//    var $modelMonths;
//}
//
//class ModelMonth {
//    var $archieveEntries;
//}

function createArchEntry($link, $title, $author, $pubdate) {
    $entry = new ArchieveEntry();
    $entry->link = $link;
    $entry->author = $author;
    $entry->pubdate = $pubdate;
    $entry->title = $title;
    return $entry;
}

class ArchieveProviderImpl implements IArchieveProvider {

    private $archieveEntryArray;
//    private $archieveModel;

    public function __construct() {
        // init archieveEntryArray
        $this->archieveEntryArray = array();
        $counter = 0;
        
        $archieveExportFile = "archieveExport.txt";
        echo ("<a href=$archieveExportFile>archieveExport<a/>");
        if(!file_exists($archieveExportFile)) {
            applogSevere("File does not exist: $archieveExportFile");
            die();
        }
        $archExpTct = file($archieveExportFile);
        if (!$archExpTct ) {
            applogSevere("Cannot open $archieveExportFile");
            die();
        }
        
        foreach ($archExpTct as $line) {
            $record = explode("|", $line);
            $this->archieveEntryArray[$counter++] = createArchEntry($record[0], $record[1], $record[3], $record[2]);
        }

//        $this->archieveEntryArray[$counter++] = createArchEntry("2009/1/duhov", "Духовность сегодня", "И. Аксёнов", "23.01.2009");
//        $this->archieveEntryArray[$counter++] = createArchEntry("2009/1/duhov", "Рождество", "И. Аксёнов", "28.01.2009");
//        $this->archieveEntryArray[$counter++] = createArchEntry("2009/1/duhov", "Рождество2", "", "29.01.2009");
//        $this->archieveEntryArray[$counter++] = createArchEntry("2009/2/duhov", "Рождество3", "проф. Осипов", "14.02.2009");
//        $this->archieveEntryArray[$counter++] = createArchEntry("2008/2/duhov", "Рождество2008", "проф. Осипов", "12.02.2008");
//        $this->archieveEntryArray[$counter++] = createArchEntry("2009/1/duhov", "Духовность сегодня", "И. Аксёнов", "23.01.2009");
//        $this->archieveEntryArray[$counter++] = createArchEntry("2009/1/duhov", "Рождество", "И. Аксёнов", "28.01.2009");
//        $this->archieveEntryArray[$counter++] = createArchEntry("2009/1/duhov", "Рождество2", "", "29.01.2009");
//        $this->archieveEntryArray[$counter++] = createArchEntry("2009/2/duhov", "Рождество3", "проф. Осипов", "14.02.2009");
//        $this->archieveEntryArray[$counter++] = createArchEntry("2008/2/duhov", "Рождество2008", "проф. Осипов", "12.02.2008");
//        $this->archieveEntryArray[$counter++] = createArchEntry("2009/1/duhov", "Духовность сегодня", "И. Аксёнов", "23.01.2009");
//        $this->archieveEntryArray[$counter++] = createArchEntry("2009/1/duhov", "Рождество", "И. Аксёнов", "28.01.2009");
//        $this->archieveEntryArray[$counter++] = createArchEntry("2009/1/duhov", "Рождество2", "", "29.01.2009");
//        $this->archieveEntryArray[$counter++] = createArchEntry("2009/2/duhov", "Рождество3", "проф. Осипов", "14.02.2009");
//        $this->archieveEntryArray[$counter++] = createArchEntry("2008/2/duhov", "Рождество2008", "проф. Осипов", "12.02.2008");
//        $this->archieveEntryArray[$counter++] = createArchEntry("2009/1/duhov", "Духовность сегодня", "И. Аксёнов", "23.01.2009");
//        $this->archieveEntryArray[$counter++] = createArchEntry("2009/1/duhov", "Рождество", "И. Аксёнов", "28.01.2009");
//        $this->archieveEntryArray[$counter++] = createArchEntry("2009/1/duhov", "Рождество2", "", "29.01.2009");
//        $this->archieveEntryArray[$counter++] = createArchEntry("2009/2/duhov", "Рождество3", "проф. Осипов", "14.02.2009");
//        $this->archieveEntryArray[$counter++] = createArchEntry("2008/2/duhov", "Рождество2008", "проф. Осипов", "12.02.2008");

//        $this->initModel();
    }

//    private function initModel(){
//        $years = $this->getYears();
//
//    }

    /**
     * @param neededPart can be "DAY", "MONTH", "YEAR"
     */
    private function parseDate($date, $neededPart) {
        global $DEBUG;

        $dateTime = strtotime($date);

        if(!$dateTime) {
            die("Invalid date format = $date");
        }

        switch ($neededPart) {
            case "YEAR":
                $part = strftime('%Y', $dateTime);
                break;
            case "MONTH":
                $part = strftime('%m', $dateTime);
                break;
            case "DAY":
                $part = strftime('%e', $dateTime);
                break;
            default:
                $msg = "invalid param neededPart=$neededPart";
                applogSevere($msg);
                die($msg);
        }

        if ($DEBUG) {
            //print_r("parseDate: parsed $neededPart '$part' from $date<br>");
        }

        return $part;
    }

    public function getYears() {
        global $DEBUG;

        $count = 0;
        $years = array();

        if ($DEBUG) {
            print_r("getYears: archieve array size = ".count($this->archieveEntryArray)."<br>");
        }

        for($i=0; $i < count($this->archieveEntryArray); $i++) {
            $currentEntryYear = $this->parseDate($this->archieveEntryArray[$i]->pubdate, "YEAR");

            $yearExists = false;
            for($k=0; $k < count($years); $k++) {
                if ($currentEntryYear == $years[$k]) {
                    $yearExists = true;
                }
            }
            if (!$yearExists) {
                $years[count($years)] = $currentEntryYear;
            }
        }
        if ($DEBUG) {
            print_r("getYears: found years = ");
            print_r($years);
            print_r("<br>");
        }
        return $years;
    }

    public function getMonths($year) {
        global $DEBUG;

        $count = 0;
        $months = array();

        for($i=0; $i < count($this->archieveEntryArray); $i++) {
            $currentEntryYear = $this->parseDate($this->archieveEntryArray[$i]->pubdate, "YEAR");

            if ($currentEntryYear != $year) {
                continue;
            }

            $currentEntryMonth = $this->parseDate($this->archieveEntryArray[$i]->pubdate, "MONTH");
            $monthExists = false;

            for($k=0; $k < count($months); $k++) {
                if ($currentEntryMonth == $months[$k]) {
                    $monthExists = true;
                }
            }
            if (!$monthExists) {
                $months[count($months)] = $currentEntryMonth;
            }
        }
        if ($DEBUG) {
            print_r("getMonths: found months = ");
            print_r($months);
            print_r("<br>");
        }
        return $months;
    }

    public function getLinks($year, $month) {
        global $DEBUG;

        $count = 0;
        $links = array();

        for($i=0; $i < count($this->archieveEntryArray); $i++) {
            $currentEntryYear = $this->parseDate($this->archieveEntryArray[$i]->pubdate, "YEAR");
            $currentEntryMonth = $this->parseDate($this->archieveEntryArray[$i]->pubdate, "MONTH");

            if ($currentEntryYear == $year && $currentEntryMonth == $month) {
                // add link
                $realLink = "articles.php?s={$this->archieveEntryArray[$i]->link}";
                $ahref = "<a href=$realLink>{$this->archieveEntryArray[$i]->title}</a>";
                $date = "<i>{$this->archieveEntryArray[$i]->pubdate}</i>";
                $tmpAuthor = $this->archieveEntryArray[$i]->author;
                $author = $tmpAuthor ? "<i> ($tmpAuthor)</i>" : "";
                $links[count($links)] = $date." ".$ahref.$author;
            }
        }
        if ($DEBUG) {
            print_r("getMonths: found months = ");
            print_r($links);
            print_r("<br>");
        }
        return $links;
    }
}
?>
