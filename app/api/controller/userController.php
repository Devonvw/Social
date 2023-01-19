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
        $body = json_decode(file_get_contents('php://input'), true);

        $this->userService->loginUser($body["username"], $body["password"]);
        return json_encode($_SESSION);
    }

    public function createUser()
    {
        $body = json_decode(file_get_contents('php://input'), true);

        $this->userService->createUser($body["username"], $body["password"]);
    }

    public function logout()
    {
        $this->userService->logoutUser();
    }

    public function getMyPosts()
    {
        echo json_encode($this->userService->getMyPosts());
    }
}
?>