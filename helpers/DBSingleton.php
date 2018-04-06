<?php
class DBSingleton {

  private static $instance;

  private $_conn;
  private $_config;

  public static function getInstance() {
    if(!self::$instance) {
      self::$instance = new self();
    }
    return self::$instance;
  }

  private function __clone() {}

  private function __construct() {
    $this->_config = json_decode(file_get_contents('conf/db_config.json'));
    try {
      $this->_conn = new PDO('mysql:host='.$this->_config->host.';port='.$this->_config->port.';dbname='.$this->_config->database, $this->_config->username, $this->_config->password);
    } catch(Exception $e) {
			//TODO
      var_dump($e);
    }
  }

  public function query($sql, $class) {
    $res = $this->_conn->query($sql);
    if(!$res) {
      return [];
    }
    return $res->fetchAll(PDO::FETCH_CLASS, $class,  array_keys(get_class_vars($class)));
  }
}
?>
