<?php
/**
 * This class reads info from article file
 * (title, author, publication date, etc.)
 * Readed info is accumulated in $articleInfoArr
 * which elements are instances of ArticleInfo class.
 */
class ArticleInfoReader {

    var $articleInfoArr;
    var $logger;

    /**
     * Creates instance.
     */
    function ArticleInfoReader() {
        $this->articleInfoArr = array();
        $root = "../";
        $this->logger = new Logger($root, "ArticleInfoReader");
    }

    private function logError($msg) {
        $this->logger->applogSevere($msg);
    }

    private function logDebug($msg) {
        $this->logger->applogDebug($msg);
    }


    /**
     * Reads article info from filePath and accumulates it
     * in the $articleInfoArr array.
     * This method can be used several times - all readed info
     * will be accumulated in the array.
     *
     * @param filePath path to the article file
     */
    function read($filePath) {
        if (!file_exists($filePath)) {
            $this->logError("File can not be found: ".$filePath);
            return;
        }
        if (!is_readable($filePath)) {
            $this->logError("File is not readable: ".$filePath);
            return;
        }
        $index = count($this->articleInfoArr);
        $currentInfo = new ArticleInfo();
        $currentInfo->link = $filePath;

        //read info from file
        $this->fillArticleData(&$currentInfo);
        $this->articleInfoArr[$index] = $currentInfo;
    }

    private function findValueInLine($code_line, $var_name) {
        // if var name is contained in the code line
        if (strpos($code_line, $var_name)) {
            $beginIndex = strpos($code_line, "\"") + 1;
            $endIndex = strrpos($code_line, "\"");
            $length = $endIndex - $beginIndex;
            return substr($code_line, $beginIndex, $length);
        }
    }

    private function isAllFound($articleInfo) {
        if ($articleInfo->title
            && $articleInfo->author
            && $articleInfo->pubdate
            && $articleInfo->intro
            && $articleInfo->theme) {

            // all is found
            return true;
        }
        // something is not found
        return false;
    }

    private function fillArticleData(&$articleInfo) {

        if ($this->isAllFound($articleInfo)) {
            // nothing to find
            return;
        }

        $VARNAME_TITLE = 'page_title';
        $VARNAME_AUTHOR = 'author';
        $VARNAME_PUBDATE = 'public_date';
        $VARNAME_THEME = 'theme';
        $VARNAME_INTRO = 'intro';

        $artilceLink = $articleInfo->link;
        $this->logDebug("archieved link = ".$artilceLink);
        if (file_exists($artilceLink)) {
            $fileArray = file($artilceLink);

            for ($i=0; $i<=sizeof($fileArray); $i++) {
                // if all var values have been found then break
                if ($this->isAllFound($articleInfo)) {
                    break;
                }

                // try to find any var value on this line
                if (!$articleInfo->title) {
                    $articleInfo->title = $this->findValueInLine($fileArray[$i], $VARNAME_TITLE);
                }
                if (!$articleInfo->author) {
                    $articleInfo->author = $this->findValueInLine($fileArray[$i], $VARNAME_AUTHOR);
                }
                if (!$articleInfo->pubdate) {
                    $articleInfo->pubdate = $this->findValueInLine($fileArray[$i], $VARNAME_PUBDATE);
                }
                if (!$articleInfo->theme) {
                    $articleInfo->theme = $this->findValueInLine($fileArray[$i], $VARNAME_THEME);
                }
                if (!$articleInfo->intro) {
                    $articleInfo->intro = $this->findValueInLine($fileArray[$i], $VARNAME_INTRO);
                }
            }

            // searching is finished. print results
            if (!$articleInfo->title) {
                $this->logError("'$artilceLink': cannot find article info - $VARNAME_TITLE");
            }
            if (!$articleInfo->author) {
                $this->logError("'$artilceLink': cannot find article info - $VARNAME_AUTHOR");
            }
            if (!$articleInfo->pubdate) {
                $this->logError("'$artilceLink': cannot find article info - $VARNAME_PUBDATE");
            }
            if (!$articleInfo->theme) {
                $this->logError("'$artilceLink': cannot find article info - $VARNAME_THEME");
            }
            if (!$articleInfo->intro) {
                $this->logError("'$artilceLink': cannot find article info - $VARNAME_INTRO");
            }
        } else {
            $msg = "Article's file not found in '$artilceLink'";
            $this->logError($msg);
            echo($msg);
        }
    }
}
?>
