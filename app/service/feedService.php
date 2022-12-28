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
}

?>