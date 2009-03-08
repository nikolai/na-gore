<?php
require_once 'ArticleInfoSaver.php';
require_once 'ArticleInfoReader.php';
require_once 'Util.php';

class ArticleInfoManager {
    var $root;
    var $saver;
    var $logger;

    function ArticleInfoManager($root) {
        $this->root = $root;
        $this->saver = new ArticleInfoSaver($this->root);
        $this->logger = new Logger($root, "ArticleInfoManager");
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

    function getArticleInfo($path) {
        // open articlesInfo.txt
        $lines = file($this->saver->articlesInfoFile);
        if (!$lines || count($lines) <= 0) {
            $msg = "can not read articles info file '$this->saver->articlesInfoFile'";
            $this->logger->applogSevere($msg);
            die($msg);
        }

        for ($i=0; $i < count($lines); $i++) {
            if (strcmp($path, $this->getPath($lines[$i])) == 0) {
                return $this->parseArticleInfo($lines[$i]);
            }
        }
        $this->logger->applogSevere("can not find article info for the path '$path'");
    }

    private function getPath($line) {
        $lineWithoutN = cutNewLine($line);
        //$this->logger->applogInfo("getPath: $lineWithoutN");
        $columns = explode($this->saver->columnDelimeter, $lineWithoutN);
        return $columns[0];
    }
    private function parseArticleInfo($line) {
        $lineWithoutN = cutNewLine($line);
        $columns = explode($this->saver->columnDelimeter, $lineWithoutN);
        
        $articleInfo = new ArticleInfo();

        $articleInfo->link = $columns[0];
        $articleInfo->title = $columns[1];
        $articleInfo->author = $columns[2];
        $articleInfo->pubdate = $columns[3];
        $articleInfo->author = $columns[4];
        $articleInfo->theme = $columns[5];
        $articleInfo->intro = $columns[6];

        $this->logger->applogInfo("parseArticleInfo: ".$articleInfo->toString() . " from line '$line'");
        return $articleInfo;
    }
}

?>
