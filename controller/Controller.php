<?php
require_once('helpers/DBSingleton.php');
abstract class Controller {

  protected function getDBInstance() {
    return DBSingleton::getInstance();
  }

  abstract protected function get($id);
  abstract protected function update($id, $params);
  abstract protected function delete($id);
  abstract protected function create($params);
  abstract protected function list();
}
?>
