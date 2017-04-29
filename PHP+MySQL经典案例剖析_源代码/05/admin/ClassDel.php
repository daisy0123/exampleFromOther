<?php
$blog->DelClass($_GET['CatId'],$blogid);
header("Location:Index.php?Action=Class");
?>
