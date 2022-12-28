<?php
require_once __DIR__ . '/controller.php';
require_once __DIR__ . '/../service/userService.php';

class UserController extends Controller {
    private $userService; 

    // initialize services
    function __construct() {
        $this->userService = new UserService();
    }

    public function login() {
        $this->displayView("");
    }

    public function signUp() {
      $this->displayView("");
  }
}
?>