<?php
require_once ("Logger.php");
require_once ("ArticleInfo.php");

class FileScanner {
    var $fileFilter;
    var $dirFilter;
    var $infoReader;
    var $logger;

    var $dirsProcessedCount = 0;
    var $filesProcessedCount = 0;

    function FileScanner($fileFilter, $infoReader) {
        $this->fileFilter = $fileFilter;
        $this->infoReader = $infoReader;
        $this->dirFilter = new DirFilter();
        $root = "../";
        $this->logger = new Logger($root, "FileScanner");
        $this->logDebug("FileScanner created");
    }

    private function logError($msg) {
        $this->logger->applogSevere($msg);
    }
    private function logDebug($msg) {
        $this->logger->applogDebug($msg);
    }

    function scan($dir, $root) {
        $this->logDebug("start scanning dirs from '$dir'");

        // Open dir and read its content
        if (!file_exists($dir)) {
            $this->logError("Dir '$dir' does not exist ");
            return;
        }
        if (!is_dir($dir)) {
            $this->logError("'$dir' is not dir");
            return;
        }

        $dh = opendir($dir);
        if (!$dh) {
            $this->logError("Can not open dir '$dir'");
            return;
        }

        print "<pre>";
        while (($file = readdir($dh)) !== false) {
            if (is_dir($dir.$file)) {
                if ($this->dirFilter->accept($file)) {
                    $this->scan($dir.$file."/", $root, &$this->infoReader);
                    print "<b>Папка: $dir$file : тип: " . filetype($dir . $file) . "</b>\n";
                    $this->dirsProcessedCount++;
                }
            } else {
                if ($this->fileFilter->accept($file)) {
                    $this->infoReader->read($dir.$file);
                    print "Файл: $dir$file \n";
                    $this->filesProcessedCount++;
                }
            }
        }
        print "</pre>";
        closedir($dh);
        $this->logDebug("scanning is finished. dirs - $this->dirsProcessedCount, files - $this->filesProcessedCount");
    }
}

class DirFilter {
    function accept($dirname) {
        // ignore .svn, current and parent dirs
        if (!strcmp($dirname, "..")
            ||!strcmp($dirname, ".")
            ||!strcmp($dirname, ".svn")) {
            return false;
        }
        return true;
    }
}

class ArticlesFilter {

    function accept($filename) {
        if (stristr($filename, ".htm")
            ||stristr($filename, ".php")) {
            return true;
        }
        return false;
    }
}




?>