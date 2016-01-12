<?php
class Quiz
{
  public $answers=array();
  public $right="";
  public $title;
  public $qtitle;

  public function __construct($title,$qtitle) {
    $this->title=$title;
    $this->qtitle=$qtitle;
  }

  public function add($text,$key=null) {
    if ($key==null) {$key=sizeof($this->answers);}
    $this->answers[$key]=$text;
  }

  public function apply($html,$el) {
    $legend=$html->createElement("legend");
    applyText($legend,$this->title);
    $el->appendChild($legend);
    $e=$html->createElement("form");
    $e->setAttribute("method","POST");
    $e->setAttribute("class","form-horizontal");
    $hdiv=$html->createElement("div");
    $hdiv->setAttribute("class","control-group");
    $div=$html->createElement("div");
    $div->setAttribute("class","controls");
    $label=$html->createElement("label");
    $label->setAttribute("class","control-label");
    $hdiv->appendChild($label);
    applyText($label,$this->qtitle);
    $s=$html->createElement("select");
    foreach ($this->answers as $key => $value) {
      $ad=$html->createElement("label");
      $ad->setAttribute("class","radio");
      $a=$html->createElement("input");
      $a->setAttribute("type","radio");
      $a->setAttribute("name","answer");
      $a->setAttribute("value",$key);
      $ad->appendChild($a);
      applyText($ad,$value);
      $div->appendChild($ad);
    }
    $hdiv->appendChild($div);
    $e->appendChild($hdiv);
    $el->appendChild($e);
  }
}
?>
