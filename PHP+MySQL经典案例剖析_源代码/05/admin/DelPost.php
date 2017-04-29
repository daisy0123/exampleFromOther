<?php
$blog->DelPost($_SESSION['User']['F_ID'],$_GET['PostId']);
header("Location:Index.php?Action=PostList");
?>
