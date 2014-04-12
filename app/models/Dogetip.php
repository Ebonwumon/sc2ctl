<?php

/**
 * Dogetip
 *
 * @property integer $id
 * @property integer $reciever
 * @property string $address
 * @property string $tipper
 * @property string $message
 * @property float $amount
 * @property boolean $confirmed
 * @property boolean $paid
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \User $receiver
 * @method static \Illuminate\Database\Query\Builder|\Dogetip whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Dogetip whereReciever($value)
 * @method static \Illuminate\Database\Query\Builder|\Dogetip whereAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\Dogetip whereTipper($value)
 * @method static \Illuminate\Database\Query\Builder|\Dogetip whereMessage($value)
 * @method static \Illuminate\Database\Query\Builder|\Dogetip whereAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\Dogetip whereConfirmed($value)
 * @method static \Illuminate\Database\Query\Builder|\Dogetip wherePaid($value)
 * @method static \Illuminate\Database\Query\Builder|\Dogetip whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Dogetip whereUpdatedAt($value)
 */
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
