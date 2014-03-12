<?php

class Season extends Eloquent {
  protected $guarded = array('id');
  protected $fillable = array('name', 'start_date', 'end_date');
}
