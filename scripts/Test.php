<?php
require_once 'ArticleInfoManager.php';
/**
 * Test scripts.
 */
function testStoreArticleInfo() {
    $root = "../";
    $path = $root."articles/2009/1/osipov_duhov.php";
    $articleInfoManager = new ArticleInfoManager($root);
    $articleInfoManager->storeArticleInfo($path);
    
    // TODO: verify result and return true or false
}

// run tests
testStoreArticleInfo();

?>
