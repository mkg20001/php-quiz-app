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
if (!isset($_COOKIE["quizid"])) {
  if (!isset($_GET["id"])) {
    pageError(l("id.missing"));
  }
}
$id=$_COOKIE["quizid"];
if (isset($_GET["id"])) {
  $id=$_GET["id"];
  setCookie("quizid",$id,time()+3600);
  if (!isset($_GET["uuid"])) {
    reload();
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
  pageError("uuid.invalid");
} else {
  $uuidfile=$uu;
  $uu=file_get_contents($uu);
  switch($uu) {
    case "sent":
      pageError(l("uuid.used"));
      break;
    case "":
      file_put_contents($uuidfile,"0|0");
      break;
  }
}
if (!isset($q[$id])) {
  pageError(l("id.invalid"));
} else {
  $uu=explode("|",file_get_contents($uuidfile));
  $qq=$q[$id];
  $e=jumbo();
  $pcp="progress".$id;
  $ccp="callback".$id;
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
        $uu[1]==0;
        file_put_contents($uuidfile,"$uu[0]|$uu[1]");
        reload();
      } else {
        if ($quiz->errtype=="wrong") {
          $uu[0]=$uu[0]+1;
          $uu[1]=$uu[1]+1;
          file_put_contents($uuidfile,"$uu[0]|$uu[1]");
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
    applyText($l,l("finish"));
    $p=$h->html->createElement("span");
    applyText($p,l("finish.thanks"));
    $e->appendChild($l);
    $e->appendChild($p);
    if (!isset($_COOKIE[$ccp])) {
      exec(str_replace("\$UUID",$uuid,$qq["c"]));
      setCookie($ccp,"true",time()+3600*48);
      file_put_contents($uuidfile,"sent");
    }
  } else {
    pageError("-.-");
  }
  $h->body->appendChild($e);
}

echo $h->html->saveHTML();
?>
