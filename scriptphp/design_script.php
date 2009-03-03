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
    echo("<a href='$root/index.htm'><font color='#0000FF'>�� ����.ru&nbsp;&nbsp; �����-��������� ����, �. ������.</font></a>");
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
    echo("<a href=$root/index.htm>�������</a> | ");
    echo("<a href=$root/history.htm>�������</a> | ");
    echo("<a href=$root/schedule.htm>����������</a> | ");
    echo("<a href=$root/myst.htm>��������</a> | ");
    echo("<a href=$root/articles.htm>������</a> | ");
    echo("<a href=$root/theatre.htm>������� �����</a> | ");
    echo("<a href=$root/dom.htm>��������� ���</a> | ");
    echo("<a href=$root/podvor.htm>��������</a> | ");
    echo("<a href=$root/turma.htm>�������� � ������</a>");
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
            return "������";
        case 2:
            return "�������";
        case 3:
            return "����";
        case 4:
            return "������";
        case 5:
            return "���";
        case 6:
            return "����";
        case 7:
            return "����";
        case 8:
            return "������";
        case 9:
            return "��������";
        case 10:
            return "�������";
        case 11:
            return "������";
        case 12:
            return "�������";
        default: die("Invalid month number = $month");
    }
}
?>