<?php
require __DIR__ . '/../DAL/FeedDAO.php';


class FeedService {
    public function GetFeed() {
        $dao = new FeedDAO();
        $feed = $dao->GetFeed();

        return $feed;
    }
}

?>