<?php

class DogeAPI {
  
  public function getAllAddressesAndBalances() {
  }

  public static function getNewAddress($id = false) {
    $str = "https://www.dogeapi.com/wow/?api_key=" . Config::get('app.doge_api_key');
    $str .= "&a=get_new_address";
    if ($id) {
      $str .= "&address_label=" . $id;
    }
    return json_decode(file_get_contents($str));
  }

  public static function getBalance($address) {
    $str = "https://www.dogeapi.com/wow/?api_key=" . Config::get('app.doge_api_key');
    $str .= "&a=get_address_received&payment_address=" . $address;
    return json_decode(file_get_contents($str));
  }
}
