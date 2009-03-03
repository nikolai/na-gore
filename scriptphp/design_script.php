<?php
/**
* design_script.php
* Contains design utilities for the articles.
*/

/* FUNCTIONS */
function start_story($page_title, $story_title, $root) {
    /* PROJECT CONSTANTS */
    $CONST_CAHRSET = "windows-1251";
    $CONST_CSS_PATH = "$root/styles.css";
    $CONST_BODY_BG_IMG_PATH = "$root/articles/img/backgrnd/1.jpg";
    $CONST_BODY_BG_COLOR = "#CFEFE4";

    // header
    echo("<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\">");
    echo("<html><head><meta http-equiv='Content-Type' content='text/html; charset=$CONST_CAHRSET'>");
    echo("<title>$page_title</title>");
    echo("<link href='$CONST_CSS_PATH' rel='stylesheet' type='text/css'>");
    echo("</head>");

    // body
    echo("<body bgcolor='$CONST_BODY_BG_COLOR' background='$CONST_BODY_BG_IMG_PATH'");
    echo("<table align='center'>");
    echo("<tr><td>");

    // top menu
    echo("<div class='menutop' style='margin:0px 0px 0px 0px;'>");
    echo("<a href='$root/index.htm'><font color='#0000FF'>НА ГОРЕ.ru&nbsp;&nbsp; Свято-Ильинский храм, г. Выборг.</font></a>");
    echo("</div>");

    // body content
    echo("</td></tr>");
    echo("<tr><td>");
    echo("<div class='telmn' style='width:770; float:left;'>");
    echo("<h1>$story_title</h1>");

}

function end_story($author, $public_date, $root) {
    echo("<br><br><i>$author</i><br>");
    echo("<i>$public_date</i>");
    echo("</div>");
    echo("</td></tr>");

    // footer menu
    echo("<tr><td>");
    echo("<div class=menu style='margin:0px 0px 2px 0px;'>");
    $root = ".";
    echo("<a href=$root/index.htm>Главная</a> | ");
    echo("<a href=$root/history.htm>История</a> | ");
    echo("<a href=$root/schedule.htm>Расписание</a> | ");
    echo("<a href=$root/myst.htm>Таинства</a> | ");
    echo("<a href=$root/articles.htm>Статьи</a> | ");
    echo("<a href=$root/theatre.htm>Детский театр</a> | ");
    echo("<a href=$root/dom.htm>Церковный дом</a> | ");
    echo("<a href=$root/podvor.htm>Подворье</a> | ");
    echo("<a href=$root/turma.htm>Служение в тюрьме</a>");
    echo("</div>");
    echo("</td></tr>");
    echo("</table>");

    // end html
    echo("</body></html>");
}

function start_default_page($page_title, $story_title, $root) {
    start_story($page_title, $story_title, $root);
}

function end_default_page() {
    end_story();
}

function mapMonth($month) {
    switch (intval($month)) {
        case 1:
            return "Январь";
        case 2:
            return "Февраль";
        case 3:
            return "Март";
        case 4:
            return "Апрель";
        case 5:
            return "Май";
        case 6:
            return "Июнь";
        case 7:
            return "Июль";
        case 8:
            return "Август";
        case 9:
            return "Сентябрь";
        case 10:
            return "Октябрь";
        case 11:
            return "Ноябрь";
        case 12:
            return "Декабрь";
        default: die("Invalid month number = $month");
    }
}
?>