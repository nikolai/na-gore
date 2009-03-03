<?php
    function findVarValue($code_line, $var_name) {
        // if var name is contained in the code line
        if (strpos($code_line, $var_name)) {
            $beginIndex = strpos($code_line, "\"") + 1;
            $endIndex = strrpos($code_line, "\"");
            $length = $endIndex - $beginIndex;
            return substr($code_line, $beginIndex, $length);
        }
    }
    function fillArticleData(&$xmlStory) {

//        // define what we need to find to construct archieve entry
//        $xmlStory->title = $xmlStory->title;
//        $xmlStory->author = $xmlStory->author;
//        $xmlStory->pubdate = $xmlStory->pubdate;

        if ($xmlStory->title && $xmlStory->author && $xmlStory->pubdate) {
            // nothing to find
            return;
        }

        $htmlExt = false;
        if (stripos($xmlStory->link, ".html")) {
            $htmlExt = true;
            applogWarning("html articles are not supported yet", "../");
            //TODO: process htm and html files!
            return;
        }

        $link = "../articles/".$xmlStory->link.".php";
        applogDebug("archieved link = ".$link, "../");
        if (file_exists($link)) {
            $file = file($link);
            
            for ($i=0; $i<=sizeof($file); $i++)
            {
                // if all var values have been found then break
                if ($xmlStory->title && $xmlStory->author && $xmlStory->pubdate) {
                    applogDebug("Found title: $xmlStory->title", "../");
                    applogDebug("Found author: $xmlStory->author", "../");
                    applogDebug("Found pubdate: $xmlStory->pubdate", "../");
                    break;
                }
                
                // try to find any var value on this line
                if (!$xmlStory->title) {
                    $xmlStory->title = findVarValue($file[$i], "page_title");
                }
                if (!$xmlStory->author) {
                    $xmlStory->author = findVarValue($file[$i], "author");
                }
                if (!$xmlStory->pubdate) {
                    $xmlStory->pubdate = findVarValue($file[$i], "public_date");
                }
            }
            
//            echo ("page_title = ".$xmlStory->title."\n");
//            echo ("author = ".$xmlStory->author."\n");
//            echo ("public_date = ".$xmlStory->pubdate."\n");
        } else {
            $msg = "Article's file not found! ".$link;
            applogSevere($msg, "../");
            echo($msg);
        }
        //echo($xmlStory->author);
    }
?>