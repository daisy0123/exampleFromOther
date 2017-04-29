<?php require_once('../../config.inc.php'); ?>
<?php require_once('../Check.php');?>
<?php require_once (INCLUDE_PATH . 'News.inc.php'); ?>
<?php
$News = new News();
$n = $News->GetClassCount();
$start = 0;
$end = 1;
$html = file_get_contents("Pub.php");
$html = str_replace("[u]","DealClass.php?n=$n&start=$start&end=$end&MenuId={$_GET['MenuId']}",$html);
echo $html;
?>
