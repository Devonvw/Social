<?php
require __DIR__ . '/../DAL/FeedDAO.php';

class FeedService {
    public function getFeed() {
        $dao = new FeedDAO();
        return $dao->getFeed();
    }

    public function getPost($post_id) {
        $dao = new FeedDAO();
        return $dao->getPost($post_id);
    }

    public function createNewPost($title, $image, $description) {
        $dao = new FeedDAO();
        $dao->createNewPost($title, $image, $description);
    }

    public function editPost($post_id, $title, $imgUrl, $description) {
        $dao = new FeedDAO();
        return $dao->editPost($post_id, $title, $imgUrl, $description);
    }

    public function deletePost($post_id) {
        $dao = new FeedDAO();
        $dao->deletePost($post_id);
    }

    public function likeUnlikePost($postId) {
        $dao = new FeedDAO();
        $dao->likeUnlikePost($postId);
    }
    
    public function addComment($comment, $postId) {
        $dao = new FeedDAO();
        $dao->addComment($comment, $postId);
    }
}

?>