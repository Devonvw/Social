<?php
require __DIR__ . '/../DAL/FeedDAO.php';

class FeedService {
    public function GetFeed() {
        try {
            $dao = new FeedDAO();
            return $dao->GetFeed();
        } catch (Exception $ex){
            if($ex->getCode() == 0) 
                echo header("HTTP/1.1 500 Something went wrong.");
            else echo header("HTTP/1.1 500 ".$ex->getMessage());
        }
    }
    public function GetPost($post_id) {
        try {
            $dao = new FeedDAO();
            return $dao->GetPost($post_id);
        } catch (Exception $ex){
            if($ex->getCode() == 0) 
                echo header("HTTP/1.1 500 Something went wrong.");
            else echo header("HTTP/1.1 500 ".$ex->getMessage());
        }
    }
    public function CreateNewPost($title, $imgUrl, $description) {
        try {
            $dao = new FeedDAO();
            $dao->CreateNewPost($title, $imgUrl, $description);
        } catch (Exception $ex){
            if($ex->getCode() == 0) 
                echo header("HTTP/1.1 500 Something went wrong.");
            else echo header("HTTP/1.1 500 ".$ex->getMessage());
        }
    }
    public function EditPost($post_id, $title, $imgUrl, $description) {
        try {
            $dao = new FeedDAO();
            return $dao->EditPost($post_id, $title, $imgUrl, $description);
        } catch (Exception $ex){
            if($ex->getCode() == 0) 
                echo header("HTTP/1.1 500 Something went wrong.");
            else echo header("HTTP/1.1 500 ".$ex->getMessage());
        }
    }
    public function DeletePost($id) {
        try {
            $dao = new FeedDAO();
            $dao->DeletePost($id);
        } catch (Exception $ex){
            if($ex->getCode() == 0) 
                echo header("HTTP/1.1 500 Something went wrong.");
            else echo header("HTTP/1.1 500 ".$ex->getMessage());
        }
    }
    public function LikeUnlikePost($postId) {
        try {
            $dao = new FeedDAO();
            $dao->LikeUnlikePost($postId);
        } catch (Exception $ex){
            if($ex->getCode() == 0) 
                echo header("HTTP/1.1 500 Something went wrong.");
            else echo header("HTTP/1.1 500 ".$ex->getMessage());
        }
    }
    public function AddComment($comment, $postId) {
        try {
            $dao = new FeedDAO();
            $dao->AddComment($comment, $postId);
        } catch (Exception $ex){
            if($ex->getCode() == 0) 
                echo header("HTTP/1.1 500 Something went wrong.");
            else echo header("HTTP/1.1 500 ".$ex->getMessage());
        }
    }
}

?>