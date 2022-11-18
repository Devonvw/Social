<?php
require_once("DAL/UserDAO.php");
class UserController {
  // Properties
  public $userDAO;

  function __construct() {
    $this->userDAO = new UserDAO();
  }

  function LoginUser($username, $password) {
    try {
        $this->userDAO->LoginUser($username, $password);
    } catch (Exception $ex) {
        throw new Exception($ex);
    }
  }

  function CreateUser($username, $password) {
    try {
        $this->userDAO->CreateUser($username, $password);
    } catch (Exception $ex) {
        throw new Exception($ex);
    }
  }
}
?>