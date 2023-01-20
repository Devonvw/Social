<?php
require_once __DIR__ . '/../DAL/UserDAO.php';

class UserService {
    public function logoutUser() {
        try {
            $dao = new UserDAO();
            $dao->logoutUser();
        } catch (Exception $ex){
            http_response_code(500);
            if($ex->getCode() != 0) echo json_encode([ 'msg' => $ex->getMessage() ]);
        }
    }

    public function loginUser($username, $password) {
        try {
            $dao = new UserDAO();
            $dao->loginUser($username, $password);
        } catch (Exception $ex){
            http_response_code(500);
            if($ex->getCode() != 0) echo json_encode([ 'msg' => $ex->getMessage() ]);
        }
    }

    public function createUser($username, $password) {
        try {
            $dao = new UserDAO();
            $dao->createUser($username, $password);
        } catch (Exception $ex){
            http_response_code(500);
            if($ex->getCode() != 0) echo json_encode([ 'msg' => $ex->getMessage() ]);
        }
    }

    public function getMyPosts() {
        try {
            $dao = new UserDAO();
            return $dao->getMyPosts();
        } catch (Exception $ex){
            http_response_code(500);
            if($ex->getCode() != 0) echo json_encode([ 'msg' => $ex->getMessage() ]);
        }
    }
}
?>