<?php
function applyText($el,$text) {
  $el->appendChild($el->ownerDocument->createTextNode($text));
}
include("./html.php");
include("./elements.php");
include("./parser.php");
?>
