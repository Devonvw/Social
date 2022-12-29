<?php
require __DIR__ . '/../DAL/FeedDAO.php';

class FeedService {
    public function GetFeed() {
        $dao = new FeedDAO();
        $feed = $dao->GetFeed();

        return $feed;
    }
    public function CreateNewPost($title, $imgUrl, $description) {
        $dao = new FeedDAO();
        $dao->CreateNewPost($title, $imgUrl, $description);
    }
    public function LikeUnlikePost($postId) {
        $dao = new FeedDAO();
        $dao->LikeUnlikePost($postId);
    }
}

?>