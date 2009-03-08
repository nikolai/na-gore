<?php

class ArticleInfo {
    var $title;
    var $author;
    var $pubdate;
    var $intro;
    var $theme;
    var $link;

    function toString() {
        return "ArticleInfo[link=$this->link,title=$this->title,theme=$this->theme]";
    }
}

?>
