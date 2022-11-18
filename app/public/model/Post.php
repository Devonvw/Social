<?php
class Post {
  // Properties
  public $id;
  public $title;
  public $imgLink;
  public $description;
  public $likes;
  public User $user;

  function __construct($id, $title, $imgLink, $description, $likes, $user) {
    $this->id = $id;
    $this->title = $title;
    $this->imgLink = $imgLink;
    $this->description = $description;
    $this->likes = $likes;
    $this->user = $user;
  }
}
?>