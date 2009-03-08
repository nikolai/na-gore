<?php
require_once 'ArticleinfoManager.php';
require_once 'Util.php';

/**
 * Configurator
 * Created on 08.03.2009 20:51:50
 * @author nikolai
 */
class Configurator {
    var $firstPageAtricleInfos;
    var $articleinfoManager;
    var $firstpageConfigFile;
    var $logger;

    function Configurator($root) {
        $this->articleinfoManager = new ArticleinfoManager($root);
        $this->firstpageConfigFile = $root."conf/indexArticles.txt";
        $this->logger = new Logger($root, "Configurator");
    }

    function getFirsPageArticles() {
        if ($this->firstPageAtricleInfos == null) {
            $this->firstPageAtricleInfos = $this->readFirstPageConfig();
        }
        return $this->firstPageAtricleInfos;
    }

    private function readConfig(){
        $lines = file($this->firstpageConfigFile);

        // TODO: read index articles paths to array and return it
        if (!$lines || count($lines) <= 0) {
            $this->logErrorDie("Can not read configuration file '$this->firstpageConfigFile'");
        }

        // every line is a path to article
        // cut new line symbol
        $paths = array();
        $index = 0;
        foreach ($lines as $line) {
            $paths[$index++] = cutNewLine($line);
        }
        return $paths;
    }

    private function readFirstPageConfig() {
        $firstPageArticlesPaths = $this->readConfig();
//        print "<pre>";
//        print_r($firstPageArticlesPaths);
//        print "</pre>";

        if (count($firstPageArticlesPaths) <= 0) {
            $this->logErrorDie("configuration file '$this->firstpageConfigFile' does not contain first page articles paths!");
        }

        $index = 0;
        $articleInfos = array();

        for ($i = 0; $i < count($firstPageArticlesPaths); $i++) {
            $artInfoTmp = $this->articleinfoManager->getArticleInfo($firstPageArticlesPaths[$i]);
            if (!$artInfoTmp) {
                $this->logError("article '$firstPageArticlesPaths[$i]' will not be included in the first page");
            } else {
                $articleInfos[$index++] = $artInfoTmp;
            }
        }
//        print "<pre>";
//        print_r($articleInfos);
//        print "</pre>";
        return $articleInfos;
    }

    private function logError($msg) {
        $this->logger->applogSevere($msg);
    }
    private function logErrorDie($msg) {
        $this->logger->applogSevere($msg);
        die($msg);
    }
}
?>
