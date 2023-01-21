<?php
require __DIR__ . '/../../service/feedService.php';

class APIFeedController
{
    private $feedService;

    // initialize services
    function __construct()
    {
        $this->feedService = new FeedService();
    }

    public function getFeed()
    {
        try {
            echo json_encode($this->feedService->getFeed());
        } catch (Exception $ex){
            http_response_code(500);
            if($ex->getCode() != 0) echo json_encode([ 'msg' => $ex->getMessage() ]);
        }
    }
    
    public function getPost($post_id)
    {
        try {
            echo json_encode($this->feedService->getPost($post_id));
        } catch (Exception $ex){
            http_response_code(500);
            if($ex->getCode() != 0) echo json_encode([ 'msg' => $ex->getMessage() ]);
        }
    }

    public function createNewPost()
    {
        try {
            $image = $_FILES ? ($_FILES["image"]["name"] ? $_FILES["image"] : false) : false;
            $this->feedService->createNewPost($_POST["title"], $image, $_POST["description"]);
        } catch (Exception $ex){
            http_response_code(500);
            if($ex->getCode() != 0) echo json_encode([ 'msg' => $ex->getMessage() ]);
        }
    }

    public function editPost()
    {
        try {
            $image = $_FILES ? ($_FILES["image"]["name"] ? $_FILES["image"] : false) : false;
            $this->feedService->editPost($_POST["post_id"], $_POST["title"], $image, $_POST["description"]);
        } catch (Exception $ex){
            http_response_code(500);
            if($ex->getCode() != 0) echo json_encode([ 'msg' => $ex->getMessage() ]);
        }
    }

    public function deletePost($post_id)
    {
        try {
            $this->feedService->deletePost($post_id);
        } catch (Exception $ex){
            http_response_code(500);
            if($ex->getCode() != 0) echo json_encode([ 'msg' => $ex->getMessage() ]);
        }
    }

    public function likeUnlikePost()
    {
        try {
            $body = json_decode(file_get_contents('php://input'), true);
            $this->feedService->likeUnlikePost($body["post_id"]);
        } catch (Exception $ex){
            http_response_code(500);
            if($ex->getCode() != 0) echo json_encode([ 'msg' => $ex->getMessage() ]);
        }
    }

    public function addComment()
    {
        try {
            $body = json_decode(file_get_contents('php://input'), true);
            $this->feedService->addComment($body["comment"], $body["post_id"]);
        } catch (Exception $ex){
            http_response_code(500);
            if($ex->getCode() != 0) echo json_encode([ 'msg' => $ex->getMessage() ]);
        }
    }
}
?>