<?php
class Post {
  // Properties
  public $id;
  public $title;
  public $image_url;
  public $description;
  public $likes;
  public $liked;
  public $created_at;
  public User $user;

  function __construct($id = null, $title = null, $image_url = null, $description = null, $likes = null, $liked = null, $created_at = null, $user = null) {
    if(!is_null($id) && !is_null($title) && !is_null($image_url) && !is_null($user)) {
      $this->id = $id;
      $this->title = $title;
      $this->image_url = $image_url;
      $this->description = is_null($description) ? "" : $description;
      $this->likes = is_null($likes) ? 0 : $likes;
      $this->liked = $liked != 0;
      $this->created_at = $created_at;
      $this->user = $user;
    }
  }

  public function __set($name, $value) {}

}
?>