<?php
if (file_exists("questions.config")) {
  $q=file_get_contents("questions.config");
  $q=explode("\n",$q);
  $a=array();
  $cur="";
  $curid=0;
  foreach ($q as $str) {
    $p=substr($str,1);
    switch(substr($str,0,1)) {
      case "*":
        $cur=explode("|",$p);
        $curid=$cur[1];
        $a[$curid]=array("name" => $cur[0],"q" => array());
        $cur=$curid;
        $curid=0;

        break;
      case "~":
        $a[$cur]["c"]=$p;
        break;
      case "$":
        $a[$cur]["s"]=explode("|",$p);
        break;
      case ";":
        $t=array();
        $qa=explode("?",$p);
        $q=$qa[0];
        $t["q"]=$q."?";
        $t["a"]=array();
        $id=0;
        $ar=explode("|",$qa[1]);
        foreach ($ar as $ans) {
          $rr=false;
          if (substr($ans,-1)=="}") {
            $rr=true;
            $ans=str_replace("}","",$ans);
          }
          if ($ans!="") {
            $t["a"][$id]=array("name" => $ans,"right" => $rr);
          }
          $id++;
        }
        $a[$cur]["q"][$curid]=$t;
        $curid++;
        break;
    }
  }
  $GLOBALS["qqq"]=$a;
} else {
  die("Please create questions.config");
}
?>
