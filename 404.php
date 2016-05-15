<?php
$uri=explode("?",$_SERVER['PHP_SELF'])[0];
$uri=str_replace("404.php","",$uri);
header("Location: $uri");
?>
<center style="font-family:sans-serif;"><h1><b><a href="<?php echo $uri; ?>">404</a></b></h1></center>
