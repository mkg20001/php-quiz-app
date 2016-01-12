<?php
$lang=substr($_SERVER["HTTP_ACCEPT_LANGUAGE"],0,2);
$lp="./locale/$lang";
if (!file_exists($lp)) {$lp="./locale/en";}

$GLOBALS["locale"]=array();
function loadLocale($path) {
  $l=file_get_contents($path);
  $l=explode("\n",$l);
  foreach ($l as $v) {
    $v=explode("=",$v);
    if (isset($v[1])) {$GLOBALS["locale"][$v[0]]=$v[1];}
  }
}
if ($lp!="./locale/en") {loadLocale("./locale/en");}
loadLocale($lp);

function l($id) {
  return $GLOBALS["locale"][$id];
}
?>
