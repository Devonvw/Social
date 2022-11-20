<?php
class Post {
  // Properties
  public $id;
  public $title;
  public $imgLink;
  public $description;
  public $likes;
  public User $user;

  function __construct($id = null, $title = null, $imgLink = null, $description = null, $likes = null, $user = null) {
    if(!is_null($id) && !is_null($title) && !is_null($imgLink) && !is_null($user)) {
      $this->id = $id;
      $this->title = $title;
      $this->imgLink = $imgLink;
      $this->description = is_null($description) ? "" : $description;
      $this->likes = is_null($likes) ? 0 : $likes;
      $this->user = $user;
    }
  }

  public function __set($name, $value) {}

}
?>