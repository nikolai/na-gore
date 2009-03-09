<?php 
$DEBUG = false;
require_once("scriptphp/logging.php");
require_once("scriptphp/design_script.php");
require_once("scriptphp/IArchieveProvider.php");
require_once("scriptphp/ArchieveProviderImpl.php");
require_once("scriptphp/ArchieveProviderFactory.php");

accesslog("begin");
// stuff functions and classes

function isValidYear($year) {
    // magic number 2003 is nearly the year the site foundation
    return !(!$year || ($year < 2003));
}
function isValidMonth($month) {
    // 1 = January, 12 = December
    return !(!$month || $month < 1 || $month > 12);
}

function isValidLinksNumber($number) {
    return !(!$number || ($number != "all" && $number < 0));
}

//function getArchieveViewLink($year, $month) {
//    return "./archieve.php?y=$year".($month ? "&m=$month" : "");
//}

function getArchieveViewLink($theme, $year, $month) {
    $themeParameter = $theme ? "&t=$theme" : "";
    $yearParameter  = $year  ? "&y=$year" : "";
    $monthParameter = $month ? "&m=$month" : "";
    return "./archieve.php?".$themeParameter.$yearParameter.$monthParameter;
}

function getMainView($archieveProvider, $linkNumber) {
    return getYearsSortedView($archieveProvider, $linkNumber);
}

function getYearsSortedView($archieveProvider, $linkNumber) {
    global $DEBUG;
    $years = $archieveProvider->getYears();

    if($DEBUG) {
        print_r("getYearsSortedView: linkNumber = $linkNumber<br>");
        print_r("getYearsSortedView: yearsCount = ".count($years)."<br>");
    }

    $view  = "<UL>";
    for($i = 0; $i < count($years); $i++) {
        $yearLink = "<a href=\"".getArchieveViewLink($years[$i])."\">{$years[$i]}</a>";
        $view .= "<LI> $yearLink";
        $view .= getYearView($archieveProvider, $years[$i], $linkNumber);
    }
    $view .= "</UL>";
    return $view;
}

function getThemesSortedView($archieveProvider, $year, $linkNumber) {
    global $DEBUG;
    $themes = $archieveProvider->getThemes();

    if($DEBUG) {
        print_r("getThemesSortedView: linkNumber = $linkNumber<br>");
        print_r("getThemesSortedView: themesCount = ".count($themes)."<br>");
    }

    $view  = "<UL>";
    for($i = 0; $i < count($themes); $i++) {
        $yearLink = "<a href=\"".getArchieveViewLink($themes[$i])."\">themes</a>";
        $view .= "<LI> $yearLink";
        $view .= getYearView($archieveProvider, $themes[$i], $linkNumber);
    }
    $view .= "</UL>";
    return $view;
}

function getYearView($archieveProvider, $year, $linkNumber) {
    global $DEBUG;
    $months = $archieveProvider->getMonths($year);

    if($DEBUG) {
        print_r("getYearView: monthsCount = ".count($months)."<br>");
    }

    $view  = "<UL>";
    for($i = 0; $i < count($months); $i++) {
        $monthLink = "<a href=\"".getArchieveViewLink($year, $months[$i])."\">".mapMonth($months[$i])."</a>";
        $view .= "<LI> $monthLink";
        $view .= getMonthView($archieveProvider, $year, $months[$i], $linkNumber);
    }
    $view .= "</UL>";

    return $view;
}

function getMonthView($archieveProvider, $year, $month, $linkNumber) {
    global $DEBUG;
    $realLinkNum = $linkNumber == "all" ? 32767 : $linkNumber;
    $links = $archieveProvider->getLinks($year, $month);

    $view  = "<OL>";
    for($i = 0; $i < count($links) && $i < $realLinkNum; $i++) {
        $view .= "<LI>".$links[$i];
    }

    if ($realLinkNum < count($links)) {
        $continueLink = "<a href=\"".getArchieveViewLink($year, $month)."\">продолжить...</a>";
        $view .= "<LI> $continueLink";
    }
    $view .= "</OL>";
    return $view;
}

// CONSTRUCT PAGE CONTENT
// parse params
$year = $_GET["y"];
$month = $_GET["m"];
$linkNumber = $_GET["n"];

$VIEW_MODE_MAIN = 'vm_main';    // display articles for all years
$VIEW_MODE_YEAR = 'vm_year';    // display articles for defined year and for all months
$VIEW_MODE_MONTH = 'vm_month';  // display articles for defined year and month

$viewMode;

// define viewMode
if (!isValidYear($year)) {
    $viewMode = $VIEW_MODE_MAIN;
} else if (!isValidMonth($month)) {
    $viewMode = $VIEW_MODE_YEAR;
} else {
    $viewMode = $VIEW_MODE_MONTH;
}

// define max number of links to display
if (!isValidLinksNumber($linkNumber)){
    switch ($viewMode) {
        case $VIEW_MODE_MAIN:
            $linkNumber = 5;
            break;
        case $VIEW_MODE_YEAR:
            $linkNumber = 10;
            $archieveTitle = "$archieveTitle за $year год";
            break;
        case $VIEW_MODE_MONTH:
            $linkNumber = 'all';
            $monthStr = mapMonth($month);
            $archieveTitle = "$archieveTitle за $monthStr $year года";
            break;
        default:
            $ms = "invalid view mode = $viewMode";
            applogSevere($ms);
            die($ms);
    }
}

// and construct the title
$archieveTitle = "Архив статей";
switch ($viewMode) {
    case $VIEW_MODE_YEAR:
        $archieveTitle = "$archieveTitle за $year год";
        break;
    case $VIEW_MODE_MONTH:
        $monthStr = mapMonth($month);
        $archieveTitle = "$archieveTitle за $monthStr $year года";
        break;
}

if ($DEBUG) {
    print_r("viewMode=$viewMode<br>");
    print_r("linkNumber=$linkNumber<br>");
    print_r("archieveTitle=$archieveTitle<br>");
}

// out archieve content
start_default_page("Архив статей", $archieveTitle, ".");

$archieveProviderFactory = new ArchieveProviderFactory();
$archieveProvider = $archieveProviderFactory->createProvider();

switch ($viewMode) {
    case $VIEW_MODE_MAIN:
        echo (getMainView($archieveProvider, $linkNumber));
        break;
    case $VIEW_MODE_YEAR:
        echo (getYearView($archieveProvider, $year, $linkNumber));
        break;
    case $VIEW_MODE_MONTH:
        echo (getMonthView($archieveProvider, $year, $month, $linkNumber));
        break;
    default:
        $ms = "invalid view mode = $viewMode";
        applogSevere($ms);
        die($ms);
}

end_default_page();
?>
