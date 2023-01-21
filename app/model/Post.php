<?php
class Post {
  public $id;
  public $title;
  public $image_type;
  public $image_data;
  public $description;
  public $likes;
  public $liked;
  public $created_at;
  public $comments;
  public User $user;

  function __construct($id = null, $title = null, $image_type = null, $image_data = null, $description = null, $likes = null, $liked = null, $created_at = null, $comments = null, $user = null) {
    if(!is_null($id) && !is_null($title) && !is_null($image_type) && !is_null($image_data) && !is_null($user)) {
      $this->id = $id;
      $this->title = $title;
      $this->image_type = $image_type;
      $this->image_data = $image_data;
      $this->description = is_null($description) ? "" : $description;
      $this->likes = is_null($likes) ? 0 : $likes;
      $this->liked = $liked != 0;
      $this->created_at = $created_at;
      $this->comments = $comments;
      $this->user = $user;
    }
  }

  public function __set($name, $value) {}

}
?>