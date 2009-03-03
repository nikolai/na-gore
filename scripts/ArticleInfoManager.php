<?php
require_once 'ArticleInfoSaver.php';
require_once 'ArticleInfoReader.php';

class ArticleInfoManager {
    var $root;

    function ArticleInfoManager($root) {
        $this->root = $root;
    }

    /**
     * Adds article info to the articles info table file.
     * @param path the path to article file
     */
    function storeArticleInfo($path) {
        $articleInfoReader = new ArticleInfoReader();
        $articleInfoReader->read($path);
        $articleInfoSaver = new ArticleInfoSaver($this->root);
        $articleInfoSaver->save($articleInfoReader->articleInfoArr, false);
    }
}

?>
