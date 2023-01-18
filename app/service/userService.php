<?php
require_once __DIR__ . '/../DAL/UserDAO.php';

class UserService {
    public function LogoutUser() {
        try {
            $dao = new UserDAO();
            $dao->LogoutUser();
        } catch (Exception $ex){
            if($ex->getCode() == 0) 
                echo header("HTTP/1.1 500 Something went wrong.");
            else echo header("HTTP/1.1 500 ".$ex->getMessage());
        }
    }

    public function LoginUser($username, $password) {
        try {
            $dao = new UserDAO();
            $dao->LoginUser($username, $password);
        } catch (Exception $ex){
            if($ex->getCode() == 0) 
                echo header("HTTP/1.1 500 Something went wrong.");
            else echo header("HTTP/1.1 500 ".$ex->getMessage());
        }
    }

    public function CreateUser($username, $password) {
        try {
            $dao = new UserDAO();
            $dao->CreateUser($username, $password);
        } catch (Exception $ex){
            if($ex->getCode() == 0) 
                echo header("HTTP/1.1 500 Something went wrong.");
            else echo header("HTTP/1.1 500 ".$ex->getMessage());
        }
    }

    public function GetMyPosts() {
        try {
            $dao = new UserDAO();
            return $dao->GetMyPosts();
        } catch (Exception $ex){
            if($ex->getCode() == 0) 
                echo header("HTTP/1.1 500 Something went wrong.");
            else echo header("HTTP/1.1 500 ".$ex->getMessage());
        }
    }
}
?>