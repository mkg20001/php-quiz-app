<?php
$q=$GLOBALS["qqq"];
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
function reload() {
  header("Location: ./");
  pageError("Redirect...");
}
if (!isset($_COOKIE["quizid"])) {
  if (!isset($_GET["id"])) {
    pageError("No Quiz ID set");
  }
}
$id=$_COOKIE["quizid"];
if (isset($_GET["id"])) {
  $id=$_GET["id"];
  setCookie("quizid",$id,time()+3600);
  reload();
}
if (!isset($q[$id])) {
  pageError("Invalid Quiz ID");
} else {
  $qq=$q[$id];
  $e=jumbo();
  $pcp="progress".$id;
  if (isset($_COOKIE[$pcp])) {
    $progress=$_COOKIE[$pcp];
  } else {
    setCookie($pcp,0,time()+3600*48);
    $progress=0;
  }
  $behind=$progress-1;
  if (isset($qq["q"][$progress])) {
    $q=$qq["q"][$progress];
    $h->setTitle($qq["name"].": ".$q["q"]);
    $quiz=new Quiz($qq["name"],$q["q"]);
    foreach ($q["a"] as $key => $v) {
      $quiz->add($v["name"],$key,$v["right"]);
    }
    if (isset($_POST["send"])) {
      if ($quiz->solve($_POST["answer"])) {
        setCookie($pcp,$progress+1,time()+3600*48);
        reload();
      }
    }
    $quiz->apply($h->html,$e);
  } else if (isset($qq["q"][$behind])) {
    pageError("Quiz Finished");
  } else {
    pageError("Cheater");
  }
  $h->body->appendChild($e);
}

echo $h->html->saveHTML();
?>
