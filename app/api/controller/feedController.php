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

    public function createNewPost()
    {
        $body = json_decode(file_get_contents('php://input'), true);
        $this->feedService->CreateNewPost($body["title"], $body["image_url"], $body["description"]);
    }
}
?>