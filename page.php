<?php
$q=$GLOBALS["qqq"];
/*$q=new Quiz("Questions about something","What is this for an app?");
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
}*/
$h=new HTML();
$GLOBALS["h"]=$h;
function jumbo() {
  $e=$GLOBALS["h"]->html->createElement("div");
  $e->setAttribute("class","jumbotron");
  return $e;
}
function pageError($err) {
  $err="ERROR: $err";
  $GLOBALS["h"]->setTitle($err);
  $e=jumbo();
  $legend=$GLOBALS["h"]->html->createElement("legend");
  applyText($legend,$err);
  $e->appendChild($legend);
  $GLOBALS["h"]->body->appendChild($e);
  die($GLOBALS["h"]->html->saveHTML());
}
if (!isset($_GET["id"])) {
  pageError("No Quiz ID set");
} else {
  $id=$_GET["id"];
  if (!isset($q[$id])) {
    pageError("Invalid Quiz ID");
  } else {
    $qq=$q[$id];
    $e=jumbo();
    $q=$qq["q"][0];
    $h->setTitle($qq["name"].": ".$q["q"]);
    $quiz=new Quiz($qq["name"],$q["q"]);
    foreach ($q["a"] as $key => $v) {
      $quiz->add($v["name"],$key,$v["right"]);
    }
    $quiz->apply($h->html,$e);
    $h->body->appendChild($e);
  }
}

echo $h->html->saveHTML();
?>
