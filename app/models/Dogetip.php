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
      return;
    }

    if ($this->created_at->diff(new DateTime('NOW'), true)->days > Config::get('app.tip_expiry')) {
      $this->delete();
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
