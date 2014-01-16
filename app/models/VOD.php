<?php

class VOD extends Eloquent {
  
  protected $table = "streams";
  protected $fillable = array('name', 'title', 'description', 'embed_url');

  public function embed() {
    return '<iframe 
      width="560" 
      height="315" 
      src="//www.youtube.com/embed/?v=' . $this->embed_url . '" 
      frameborder="0" 
      allowfullscreen>
      </iframe>';
  }
}
