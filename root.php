<?php
function applyText($el,$text) {
  $el->appendChild($el->ownerDocument->createTextNode($text));
}
include("./locale.php");
include("./html.php");
include("./elements.php");
include("./parser.php");
include("./page.php");
?>
