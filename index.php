<?php
include("./root.php");
$h=new HTML("test");
$q=new Quiz("Questions about something","What is this for an app?");
$q->add("Cake");
$q->add("PHP Quiz App",null,true);
$e=$h->html->createElement("div");
$e->setAttribute("class","jumbotron");
$h->body->appendChild($e);
$q->apply($h->html,$e);
if (isset($_POST["send"])) {
  if (isset($_POST["answer"])) {
    echo "Answered: ".$_POST["answer"];
  } else {
    echo "NO Answer";
  }
  echo "  __ ".$q->solve($_POST["answer"]);
}
echo $h->html->saveHTML();
?>
