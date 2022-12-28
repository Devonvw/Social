<?php
require_once __DIR__ . '/../DAL/UserDAO.php';

class UserService {
    public function LogoutUser() {
        $dao = new UserDAO();
        $dao->LogoutUser();
    }

    public function LoginUser($username, $password) {
        $dao = new UserDAO();
        $dao->LoginUser($username, $password);
    }

    public function CreateUser($username, $password) {
        $dao = new UserDAO();
        $dao->CreateUser($username, $password);
    }
}
?>