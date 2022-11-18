<?php

class User {
  // Properties
  public $id;
  public $username;
  public $password;

  function __construct($id = null, $username = null, $password = null) {
    if(!is_null($id) && !is_null($username) && !is_null($password)) {
      $this->id = $id;
      $this->username = $username;
      $this->password = $password;
    }
  }

  public function __set($name, $value) {}
}
?>