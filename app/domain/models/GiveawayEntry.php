<?php
/**
 * Created by PhpStorm.
 * User: ebon
 * Date: 09/05/14
 * Time: 16:03
 */

namespace domain\models;


use domain\exception\ValidationException;
use Illuminate\Support\MessageBag;

class GiveawayEntry extends \Eloquent {

    /** @var  integer */
    public $num_entries;
    /** @var  string */
    public $ip_address;
    /** @var  string */
    public $email;
    /** @var  integer */
    public $giveaway_id;
    /** @var  integer */
    public $code_id;

    protected $fillable = array('num_entries', 'ip_address', 'email', 'giveaway_id', 'code_id');
    protected $guarded = array('id');


    /**
     * Validate against the business rules for a giveaway entry.
     * @param array $input
     * @throws \domain\exception\ValidationException
     */
    public static function validate(array $input) {
        $rules = array('accept' => 'required|accepted',
                       'num_entries' => 'required|numeric|min:1',
                       'email' => 'required|email',
                       'ip_address' => 'required|ip',
                       'giveaway_id' => 'required|exists:giveaways,id'
        );

        $v = \Validator::make($rules, $input);
        if ($v->fails()) {
            throw new ValidationException($v);
        }

        $count_email = Giveaway::where('date(created_at)', '=', (new \DateTime('now'))->format('Y-m-d'))
            ->where('email', '=', $input['email'])->count();

        if ($count_email > 0) {
            $errors = new MessageBag("Your email has already submitted an entry for today.");
            throw new ValidationException($errors);
        }

        $count_ip = Giveaway::where('date(created_at)', '=', (new \DateTime('now'))->format('Y-m-d'))
            ->where('email', '=', $input['email'])->count();

        if ($count_ip > 0) {
            $errors = new MessageBag("Your IP address has already submitted an entry for today.");
            throw new ValidationException($errors);
        }
    }
} 