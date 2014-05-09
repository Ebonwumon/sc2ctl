<?php
/**
 * Created by PhpStorm.
 * User: ebon
 * Date: 09/05/14
 * Time: 15:58
 */

namespace domain\interf;

interface GiveawayRepositoryInterface {

    public function find($id);

    public function all();

    public function current(\DateTime $date = null);

    public function currentSet(\DateTime $date = null, $items = 1);

    public function create(array $attributes);

} 