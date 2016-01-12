<?php
include("./root.php");
$h=new HTML("test");
$q=new Quiz("Questions about something","What is this for an app?");
$q->add("Cake");
$q->add("PHP Quiz App");
$e=$h->html->createElement("div");
$e->setAttribute("class","jumbotron");
$h->body->appendChild($e);
$q->apply($h->html,$e);
echo $h->html->saveHTML();
?>
