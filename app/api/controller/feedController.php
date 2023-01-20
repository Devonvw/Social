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
        echo json_encode($this->feedService->getFeed());
    }
    public function getPost($post_id)
    {
        echo json_encode($this->feedService->getPost($post_id));
    }
    public function createNewPost()
    {
        $this->feedService->createNewPost($_POST["title"], $_FILES["image"], $_POST["description"]);
    }
    public function editPost()
    {
        $image = $_FILES ? ($_FILES["image"]["size"] ? $_FILES["image"] : false) : false;
        $this->feedService->editPost($_POST["post_id"], $_POST["title"], $image, $_POST["description"]);
    }
    public function deletePost($post_id)
    {
        $this->feedService->deletePost($post_id);
    }
    public function likeUnlikePost()
    {
        $body = json_decode(file_get_contents('php://input'), true);
        $this->feedService->likeUnlikePost($body["post_id"]);
    }
    public function addComment()
    {
        $body = json_decode(file_get_contents('php://input'), true);
        $this->feedService->addComment($body["comment"], $body["post_id"]);
    }
}
?>