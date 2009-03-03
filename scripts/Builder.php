<?php
require_once 'FileScanner.php';
require_once 'ArticleInfoSaver.php';
require_once 'ArticleInfoReader.php';

$root = "../";
$filter = new ArticlesFilter();
$articleInfoReader = new ArticleInfoReader();
$scanner = new FileScanner($filter, $articleInfoReader);

// scan files from the root and save info in articleInfoReader
$scanner->scan($root."articles/", $root);

$articleInfoSaver = new ArticleInfoSaver($root);
$articleInfoSaver->save($articleInfoReader->articleInfoArr, true);
?>
