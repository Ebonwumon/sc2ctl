<?php

/**
 * VOD
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property string $embed_url
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\VOD whereId($value) 
 * @method static \Illuminate\Database\Query\Builder|\VOD whereTitle($value) 
 * @method static \Illuminate\Database\Query\Builder|\VOD whereDescription($value) 
 * @method static \Illuminate\Database\Query\Builder|\VOD whereEmbedUrl($value) 
 * @method static \Illuminate\Database\Query\Builder|\VOD whereCreatedAt($value) 
 * @method static \Illuminate\Database\Query\Builder|\VOD whereUpdatedAt($value) 
 */
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
