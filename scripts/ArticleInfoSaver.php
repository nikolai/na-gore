<?php
require_once ("Logger.php");
require_once ("ArticleInfo.php");

/**
 * This class saves data retrieved by the ArticleInfoReader.
 * It recieves article info array and saves its elements
 * as records in text file.
 */
class ArticleInfoSaver {
    var $logger;
    var $articlesInfoFile;
    var $root;

    /**
     * Create instance of ArticleInfoSaver.
     */
    function ArticleInfoSaver($root) {
        $this->logger = new Logger($root, "ArticleInfoSaver");
        $this->root = $root;
        $this->articlesInfoFile = $root."conf/articlesInfo.txt";
    }

    /**
     * Stores article info in text file.
     *
     * @param articleInfoArray array each element of which is
     * object of ArticleInfo class.
     * @param overwrite if true the file that contains article info
     * will be overwrited. If false - records will be appended
     * to the end of the file.
     */
    function save($articleInfoArray, $overwrite) {
        if (count($articleInfoArray) <= 0) {
            $this->logger->applogSevere("No articles info in array");
            return;
        }

        $openMode = $overwrite ? "w" : "a";

        $file = fopen($this->articlesInfoFile, $openMode);

        if (!$file) {
            $this->logger->applogSevere("Can not open '$this->articlesInfoFile'");
            return;
        }

        // write to file
        for($x=0; $x < count($articleInfoArray); $x++) {
            $record = $articleInfoArray[$x]->link . "|" .
                      $articleInfoArray[$x]->title . "|" .
                      $articleInfoArray[$x]->pubdate . "|" .
                      $articleInfoArray[$x]->author. "|" .
                      $articleInfoArray[$x]->theme. "|" .
                      $articleInfoArray[$x]->intro. "\n";

            if (fwrite($file, $record) === FALSE) {
                $this->logger->applogSevere("Cannot write file ($file)");
                return;
            }
        }
    }
}
?>
