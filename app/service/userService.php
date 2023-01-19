<?php
require_once __DIR__ . '/../DAL/UserDAO.php';

class UserService {
    public function logoutUser() {
        try {
            $dao = new UserDAO();
            $dao->logoutUser();
        } catch (Exception $ex){
            if($ex->getCode() == 0) 
                echo header("HTTP/1.1 500 Something went wrong.");
            else echo header("HTTP/1.1 500 ".$ex->getMessage());
        }
    }

    public function loginUser($username, $password) {
        try {
            $dao = new UserDAO();
            $dao->loginUser($username, $password);
        } catch (Exception $ex){
            if($ex->getCode() == 0) 
                echo header("HTTP/1.1 500 Something went wrong.");
            else echo header("HTTP/1.1 500 ".$ex->getMessage());
        }
    }

    public function createUser($username, $password) {
        try {
            $dao = new UserDAO();
            $dao->createUser($username, $password);
        } catch (Exception $ex){
            if($ex->getCode() == 0) 
                echo header("HTTP/1.1 500 Something went wrong.");
            else echo header("HTTP/1.1 500 ".$ex->getMessage());
        }
    }

    public function getMyPosts() {
        try {
            $dao = new UserDAO();
            return $dao->getMyPosts();
        } catch (Exception $ex){
            if($ex->getCode() == 0) 
                echo header("HTTP/1.1 500 Something went wrong.");
            else echo header("HTTP/1.1 500 ".$ex->getMessage());
        }
    }
}
?>