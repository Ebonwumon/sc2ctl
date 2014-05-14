<?php
/**
 * Created by PhpStorm.
 * User: ebon
 * Date: 09/05/14
 * Time: 16:03
 */

namespace domain\models;


use domain\exception\ValidationException;
use domain\interf\CodeRepositoryInterface;
use Illuminate\Support\MessageBag;

class GiveawayEntry extends \Eloquent {
    protected $table = 'giveaway_entries';

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
                       'giveaway_id' => 'required|exists:giveaways,id',
                       'code' => 'required|exists:codes,text'
        );

        $messages = array(
            'num_entries.min' => "Your entry was invalid"
        );

        $v = \Validator::make($input, $rules, $messages);
        if ($v->fails()) {
            throw new ValidationException($v);
        }

        //TODO remove tight coupling to code implementation.
        $code = Code::where('text', '=', $input['code'])->firstOrFail();
        $count_code = GiveawayEntry::where('email', '=', $input['email'])->where('code_id', '=', $code->id)->count();

        if ($count_code > 0) {
            $errors = new MessageBag(array("You have already redeemed that code"));
            throw new ValidationException($errors);
        }

        /*$count_email = GiveawayEntry::where(\DB::raw('date(created_at)'), '=', (new \DateTime('now'))->format('Y-m-d'))
            ->where('email', '=', $input['email'])->count();

        if ($count_email > 0) {
            $errors = new MessageBag(array("Your email has already submitted an entry for today."));
            throw new ValidationException($errors);
        }*/

        $count_ip = GiveawayEntry::where('ip_address', '=', $input['ip_address'])->where('code_id', '=', $code->id)->count();

        if ($count_ip > 0) {
            $errors = new MessageBag(array("Your IP address has already submitted an entry with that code for today."));
            throw new ValidationException($errors);
        }
    }
} 
