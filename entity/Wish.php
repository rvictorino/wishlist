<?php
require_once('entity/Entity.php');
class Wish {

  private $id;
  private $title;
  private $url;

  public function __construct() {}

  public function getId() { return $this->id; }
  public function getTitle() { return $this->title; }
  public function getUrl() { return $this->url; }

  public function setId($id) { $this->id = $id; }
  public function setTitle($title) { $this->title = $title; }
  public function setUrl($url) { $this->url = $url; }
}
 ?>
