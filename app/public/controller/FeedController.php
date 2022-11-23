<?php
require_once("DAL/FeedDAO.php");
class FeedController {
  // Properties
  public $feedDAO;

  function __construct() {
    $this->feedDAO = new FeedDAO();
  }

  function LikeUnlikePost($postId, $loading) {
    try {
        $this->feedDAO->LikeUnlikePost($postId, $loading);
    } catch (Exception $ex) {
        throw new Exception($ex);
    }
  }

  function CreateNewPost($title, $imgUrl ,$description) {
    try {
        $this->feedDAO->CreateNewPost($title, $imgUrl ,$description);
    } catch (Exception $ex) {
        throw new Exception($ex);
    }
  }
}
?>