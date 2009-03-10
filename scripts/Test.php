<?php
require_once 'Configurator.php';
//require_once 'ArticleInfoManager.php';

/**
 * Test scripts.
 */
 
// TODO: verify result and return true or false
function testStoreArticleInfo() {
    $root = "../";
    $path = $root."articles/2009/1/osipov_duhov.php";
    $articleInfoManager = new ArticleInfoManager($root);
    $articleInfoManager->storeArticleInfo($path);
}


function testAddFirstPageArticlePath() {
	$root = "../";
    $path = $root."articles/2009/1/osipov_duhov.php";
    $configurator = new Configurator($root);
	$configurator->addFirstPageArticlePath($path);
}

// run tests
//testStoreArticleInfo();
testAddFirstPageArticlePath();

?>
