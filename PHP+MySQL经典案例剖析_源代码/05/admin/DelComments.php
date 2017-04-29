<?php
$blog->DelComments($_GET['ComId']);
header("Location:Index.php?Action=Comments");
?>
