<?php
class User {
  // Properties
  public $id;
  public $username;
  public $password;

  function __construct($id, $username, $password) {
    $this->id = $id;
    $this->username = $username;
    $this->password = $password;
  }
}
?>