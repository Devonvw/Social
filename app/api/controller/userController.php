<?php
require __DIR__ . '/../../service/userService.php';

class APIUserController
{
    private $userService;

    // initialize services
    function __construct()
    {
        $this->userService = new UserService();
    }

    public function login()
    {
        try {
            $body = json_decode(file_get_contents('php://input'), true);

            $this->userService->loginUser($body["username"], $body["password"]);
            return json_encode($_SESSION);
        } catch (Exception $ex){
            http_response_code(500);
            if($ex->getCode() != 0) echo json_encode([ 'msg' => $ex->getMessage() ]);
        }
    }

    public function createUser()
    {
        try {
            $body = json_decode(file_get_contents('php://input'), true);

            $this->userService->createUser($body["username"], $body["password"]);
        } catch (Exception $ex){
            http_response_code(500);
            if($ex->getCode() != 0) echo json_encode([ 'msg' => $ex->getMessage() ]);
        }
    }

    public function logout()
    {
        try {
            $this->userService->logoutUser();
        } catch (Exception $ex){
            http_response_code(500);
            if($ex->getCode() != 0) echo json_encode([ 'msg' => $ex->getMessage() ]);
        }
    }

    public function getMyPosts()
    {
        try {
            echo json_encode($this->userService->getMyPosts());
        } catch (Exception $ex){
            http_response_code(500);
            if($ex->getCode() != 0) echo json_encode([ 'msg' => $ex->getMessage() ]);
        }
    }
}
?>