<?php

class FacebookLikeData {
  
  public $likes;
  
  public function __construct($data) {
    $this->likes = array();
    foreach ($data as $element) {
      $like = new FacebookLike;
      $like->name = $element['name'];
      $like->id = $element['id'];
      $this->likes[] = $like;
    }
  }

  public function isLiked($id) {
    foreach ($this->likes as $like) {
      if ($like->id == $id) {
        return true;
      }
    }

    return false;
  }

}
