<?php

class User {
  public $id;
  public $username;
  public $password;

  function __construct($id = null, $username = null, $password = null) {
    if(!is_null($id) && !is_null($username)) {
      $this->id = $id;
      $this->username = $username;
      $this->password = $password;
    }
  }

  public function __set($name, $value) {}
}
?>