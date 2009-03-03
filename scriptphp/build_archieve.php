<?php
require_once ("archieve_util.php");
require_once ("logging.php");

// read archieve.xml
$export_archieve_file = "../archieveExport.txt";
$xml_file = "../archieve.xml";
$xml_archieve_entry     = "*ARCHIEVE*ARCHIEVE_ENTRY";
$xml_headline_key       = xml_archieve_entry."*TITLE";
$xml_description_key    = xml_archieve_entry."*AUTHOR";
$xml_pubdate_key        = xml_archieve_entry."*PUBDATE";
$xml_link_key           = xml_archieve_entry."*LINK";
$story_array = array(); 
$counter = 0; 

class xml_story{ 
    var $title, $author, $pubdate, $link;
}

function exportArchieveToTxt($archieveArray, $archOutFile) {
    applogInfo("exportArchieveToTxt($archieveArray [".count($archieveArray)."], $archOutFile)", "../");
    $exportFile = fopen($archOutFile, "wt");
    if (is_writable($archOutFile)) {
        if(!$exportFile) {
            applogSevere("Cannot open $archOutFile", "../");
            exit;
        }
        for($x = 0; $x < count($archieveArray); $x++){
            $record = $archieveArray[$x]->link . "|" .
                      $archieveArray[$x]->title . "|" .
                      $archieveArray[$x]->pubdate . "|" .
                      $archieveArray[$x]->author . "\n";
            if (fwrite($exportFile, $record) === FALSE) {
                applogSevere("Cannot write file ($archOutFile)", "../");
                exit;
            }
        }
    } else {
        applogSevere("File $archOutFile is not writable", "../");
    }
}

function startTag($parser, $data){ 
    global $current_tag;
    $current_tag .= "*$data";
} 

function endTag($parser, $data){ 
    global $current_tag;
    $tag_key = strrpos($current_tag, '*');
    $current_tag = substr($current_tag, 0, $tag_key);
} 

function contents($parser, $data){ 
    global $current_tag, $counter, $story_array,
    $xml_headline_key,
    $xml_description_key,
    $xml_pubdate_key,
    $xml_link_key;

    switch($current_tag){
        case $xml_headline_key:
            $story_array[$counter] = new xml_story();
            $story_array[$counter]->title = $data;
            break;
        case $xml_description_key:
            $story_array[$counter]->author = $data;
            break;
        case $xml_pubdate_key:
            $story_array[$counter]->pubdate = $data;
            break;
        case $xml_link_key:
            $story_array[$counter]->link = $data;
            fillArticleData($story_array[$counter]);
            $counter++;
            break;
    }
} 

$xml_parser = xml_parser_create(); 
xml_set_element_handler($xml_parser, "startTag", "endTag"); 
xml_set_character_data_handler($xml_parser, "contents"); 

$fp = fopen($xml_file, "r") or die("Could not open file $xml_file"); 
$data = fread($fp, filesize($xml_file)) or die("Could not read file $xml_file"); 

if(!(xml_parse($xml_parser, $data, feof($fp)))){
    $ms = "Archieve parser: error on line " . xml_get_current_line_number($xml_parser) . " of $xml_file";
    applogSevere($ms, "../");
    die($ms);
}

exportArchieveToTxt($story_array, $export_archieve_file);

xml_parser_free($xml_parser); 
fclose($fp);
?>