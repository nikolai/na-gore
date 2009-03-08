<?php
require_once 'Logger.php';
require_once 'Configurator.php';

/**
 * Description of FirsPageBuilder
 * Created on 08.03.2009 19:40:03
 * @author nikolai
 */
class FirsPageBuilder {
    var $configurator;
    var $logger;

    function FirsPageBuilder($root) {
        $this->configurator = new Configurator($root);
        $this->logger = new Logger($root, "FirsPageBuilder");
    }
    
    function build() {
        // read configuration
        $firstPageArticleInfoArr = $this->configurator->getFirsPageArticles();
        if (!$firstPageArticleInfoArr || count($firstPageArticleInfoArr) <= 0) {
            $msg = "no articles for the first page";
            $this->logger->applogSevere($msg);
            die($msg);
        }
        
        // generate first page
        // now just out infos:
        print "<pre>";
        print "first page articles:\n";
        for ($i = 0; $i < count($firstPageArticleInfoArr); $i++) {
            print "\t".($i+1).") ".$firstPageArticleInfoArr[$i]->toString()."\n";
        }
        print "</pre>";
    }
}
?>
