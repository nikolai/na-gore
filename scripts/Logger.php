<?php

/**
 * Logger performs application logging to
 * dir logs. It supports 2 kinds of logging:
 * application logging and pages access logging
 */
class Logger {
    var $root;
    var $name;
    var $applogFile;
    var $accesslogFile;

    /**
     * Creates instance of Logger
     *
     * @param root path to the root dir
     * from the current script whitch
     * uses the Logger class
     * @param name name of the logger
     */
    function Logger($root, $name) {
        $this->name = $name;
        $this->root = $root;
        $this->applogFile = "{$this->root}logs/applog.log";
        $this->accesslogFile = "{$this->root}logs/access.log";;

        if(!file_exists($root."logs")) {
            die("Cannot find logs dir in '".$root."logs'");
        }
    }

    function applogSevere($msg) {
        $this->applog($msg, "SEVERE");
    }

    function applogWarning($msg) {
        $this->applog($msg, "WARNING");
    }

    function applogInfo($msg) {
        $this->applog($msg, "INFO");
    }

    function applogDebug($msg) {
        $this->applog($msg, "DEBUG");
    }

    function accesslog($msg) {
        $level = "INFO";
        $str = $this->formatLogString($msg."|".$_SERVER['HTTP_USER_AGENT'], $level);
        error_log($str, 3, $this->accesslogFile);
    }

    private function applog($msg, $level) {
        $str = $this->formatLogString($msg, $level);
        // echo log string to the page
        //echo(str_ireplace($str."|".$this->applogFile, "\n", "<br>"));
        error_log($str, 3, $this->applogFile);
    }

    private function formatLogString($msg, $level) {
        return
        "[$this->name]" .
        date("Y/m/d h:i:s", mktime()) . "|" .
        $level . "|" .
        $_SERVER['REQUEST_URI'] . "|" .
        $msg . "\n";
    }
}
?>
