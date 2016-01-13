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
  $err=l("error").": $err";
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
if (!isset($_COOKIE["quizuuid"])) {
  if (!isset($_GET["uuid"])) {
    pageError(l("uuid.missing"));
  }
}
$uuid=$_COOKIE["quizuuid"];
if (isset($_GET["uuid"])) {
  $uuid=$_GET["uuid"];
  setCookie("quizuuid",$uuid,time()+3600);
  reload();
}
$uu="./uuid/$uuid";
if (!file_exists($uu)) {
  pageError(l("uuid.invalid"));
} else {
  $uuidfile=$uu;
  $uu=file_get_contents($uu);
  $uuu=explode("\n",$uu);
  switch($uuu[0]) {
    case "sent":
      pageError(l("uuid.used"));
      break;
    case "":
      file_put_contents($uuidfile,"0|0|0|".$uuu[1]."|".$uuu[2]);
      break;
  }
}

$uu2=explode("|",file_get_contents($uuidfile));
$uu=array();
foreach($uu2 as $k => $i) {
  if (is_numeric($i)) {
    $uu[$k]=intval($i,10);
  } else {
    $uu[$k]=$i;
  }
}
$id=$uu[3];

if (!isset($q[$id])) {
  pageError(l("id.invalid"));
} else {
  $qq=$q[$id];
  $e=jumbo();
  $progress=$uu[2];
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
        $uu[2]=$progress+1;
        $uu[1]=0;
        file_put_contents($uuidfile,implode($uu,"|"));
        reload();
      } else {
        if ($quiz->errtype=="wrong") {
          $uu[0]=$uu[0]+1;
          $uu[1]=$uu[1]+1;
          file_put_contents($uuidfile,implode($uu,"|"));
          if (($uu[0]==$qq["s"][0]) or ($uu[1]==$qq["s"][1])) {
            file_put_contents($uuidfile,"sent");
            pageError(l("error.limit"));
          }
        }
      }
    }
    $quiz->apply($h->html,$e);
  } else if (isset($qq["q"][$behind])) {
    $h->setTitle(l("quiz")." ".$qq["name"]." ".l("finished"));
    $l=$h->html->createElement("legend");
    applyText($l,l("finish").": ".$qq["name"]);
    $p=$h->html->createElement("span");
    applyText($p,l("finish.thanks"));
    $e->appendChild($l);
    $e->appendChild($p);
    exec(str_replace(["\$UUID","\$DATA"],[$uuid,$uu[4]],$qq["c"]));
    file_put_contents($uuidfile,"sent");
  } else {
    pageError("-.-");
  }
  $h->body->appendChild($e);
}

echo $h->html->saveHTML();
?>
