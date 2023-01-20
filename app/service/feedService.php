<?php
require __DIR__ . '/../DAL/FeedDAO.php';

class FeedService {
    public function getFeed() {
        try {
            $dao = new FeedDAO();
            return $dao->getFeed();
        } catch (Exception $ex){
            http_response_code(500);
            if($ex->getCode() != 0) echo json_encode([ 'msg' => $ex->getMessage() ]);
        }
    }
    public function getPost($post_id) {
        try {
            $dao = new FeedDAO();
            return $dao->getPost($post_id);
        } catch (Exception $ex){
            http_response_code(500);
            if($ex->getCode() != 0) echo json_encode([ 'msg' => $ex->getMessage() ]);
        }
    }
    public function createNewPost($title, $image, $description) {
        try {
            $dao = new FeedDAO();
            $dao->createNewPost($title, $image, $description);
        } catch (Exception $ex){
            http_response_code(500);
            if($ex->getCode() != 0) echo json_encode([ 'msg' => $ex->getMessage() ]);
        }
    }
    public function editPost($post_id, $title, $imgUrl, $description) {
        try {
            $dao = new FeedDAO();
            return $dao->editPost($post_id, $title, $imgUrl, $description);
        } catch (Exception $ex){
            http_response_code(500);
            if($ex->getCode() != 0) echo json_encode([ 'msg' => $ex->getMessage() ]);
        }
    }
    public function deletePost($post_id) {
        try {
            $dao = new FeedDAO();
            $dao->deletePost($post_id);
        } catch (Exception $ex){
            http_response_code(500);
            if($ex->getCode() != 0) echo json_encode([ 'msg' => $ex->getMessage() ]);
        }
    }
    public function likeUnlikePost($postId) {
        try {
            $dao = new FeedDAO();
            $dao->likeUnlikePost($postId);
        } catch (Exception $ex){
            http_response_code(500);
            if($ex->getCode() != 0) echo json_encode([ 'msg' => $ex->getMessage() ]);
        }
    }
    public function addComment($comment, $postId) {
        try {
            $dao = new FeedDAO();
            $dao->addComment($comment, $postId);
        } catch (Exception $ex){
            http_response_code(500);
            if($ex->getCode() != 0) echo json_encode([ 'msg' => $ex->getMessage() ]);
        }
    }
}

?>