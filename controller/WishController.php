<?php
require_once('controller/Controller.php');
require_once('entity/Wish.php');
class WishController extends Controller {

  public function __construct() {}

  public function get($id) {}
  public function update($id, $params) {}
  public function delete($id) {}
  public function create($params) {
    // $this->getDBInstance()->exec("insert into wish (, )");
  }
  public function list() {
    return $this->getDBInstance()->query("select * from wish", "Wish");
  }
}
?>
