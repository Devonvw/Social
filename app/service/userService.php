<?php
require_once __DIR__ . '/../DAL/UserDAO.php';

class UserService {
    public function logoutUser() {
        $dao = new UserDAO();
        $dao->logoutUser();
    }

    public function loginUser($username, $password) {
        $dao = new UserDAO();
        $dao->loginUser($username, $password);
    }

    public function createUser($username, $password) {
        $dao = new UserDAO();
        $dao->createUser($username, $password);
    }

    public function getMyPosts() {
        $dao = new UserDAO();
        return $dao->getMyPosts();
    }
}
?>