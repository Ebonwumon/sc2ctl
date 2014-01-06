<?php

class Dogetip extends Eloquent {

  public function receiver() {
    return $this->belongsTo('User', 'reciever');
  }

  public function verify() {
    $balance = DogeAPI::getBalance($this->address);
    if ($balance >= $this->amount) {
      $this->confirmed = true;
      $this->save();
    }
  }

  public function checkPaid() {
    $balance = DogeAPI::getBalance($this->address);
    if ($balance <= $this->amount) {
      $this->paid = true;
      $this->save();
    }
  }

}
