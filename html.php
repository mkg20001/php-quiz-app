<?php
class HTML
{
  public $html;
  public $title;
  public $style;
  public $body;
  private $nodes=array();

  public function __construct($title) {
    $this->html=new DOMDocument();
    $this->html->loadHTMLFile("template.html");
    $h=$this->html;
    $this->nodes=array("title" => $h->getElementsByTagName("title")[0],"inside" => $h->getElementById("inside"),"body" => $h->getElementsByTagName("body")[0]);
    $this->body=$h->getElementById("inside");
    $this->nodes["title"]->textContent=$title;
    $this->title=$title;
  }
}
?>
