<?php
/**
 * Created by PhpStorm.
 * User: ebon
 * Date: 09/05/14
 * Time: 16:11
 */

namespace domain\impl;


use domain\exception\ValidationException;
use domain\interf\GiveawayRepositoryInterface;
use domain\models\Code;
use domain\models\Giveaway;
use domain\models\GiveawayEntry;

class GiveawayRepositoryEloquent implements GiveawayRepositoryInterface {

    /** @var \domain\models\Giveaway  */
    protected $giveawayModel;
    protected $entryModel;

    public function __construct(Giveaway $giveawayModel, GiveawayEntry $entryModel, Code $codeModel) {
        $this->giveawayModel = $giveawayModel;
        $this->entryModel = $entryModel;
        $this->codeModel = $codeModel;
    }

    /**
     * Find a giveaway based on id
     * @param $id
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|static
     */
    public function find($id)
    {
        return $this->giveawayModel->findOrFail($id);
    }

    /**
     * Get all giveaways
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function all()
    {
        return $this->giveawayModel->all();
    }

    /**
     * Get the latest giveaway based on the given date.
     * @param \DateTime $date The date that the giveaways must end before
     * @return \Illuminate\Database\Eloquent\Model|null|static Collection of giveaways requested
     */
    public function current(\DateTime $date = null)
    {
        if ($date == null) {
            $date = new \DateTime('NOW');
        }

        return $this->giveawayModel->where('close_date', '<', $date)->orderBy('close_date', 'DESC')->first();
    }

    /**
     * Get a current set of giveaways based on a date and number of results desired.
     * @param \DateTime $date The date that the giveaways must end before
     * @param int $items Number of giveaways we want returned
     * @return array|\Illuminate\Database\Eloquent\Collection|static[] Collection of giveaways requested.
     */
    public function currentSet(\DateTime $date = null, $items = 1) {
        if ($date == null) {
            $date = new \DateTime('NOW');
        }

        return $this->giveawayModel->where('close_date', '<', $date)->orderBy('close_date', 'DESC')->take($items)->get();
    }

    /**
     * Creates a new Giveaway.
     * @param array $attributes Associative array of attributes denoting the values of the Giveaway.
     * @return Giveaway The created Giveaway object
     */
    public function create(array $attributes)
    {
        return $this->giveawayModel->create($attributes);
    }

    /**
     * Enters a giveaway.
     * @param integer $id
     * @param array $attributes
     * @throws \domain\exception\ValidationException
     */
    public function enter($id, $attributes = array()) {
        // We want to ensure that we're working with the id of a real entity.
        $this->find($id);

        //If we validate improperly an exception will be thrown.
        try {
            $this->entryModel->validate($attributes);
        } catch (ValidationException $ex) {
            throw $ex;
        }

        // This shouldn't fail, if the code doesn't exist, we'll have thrown an exception in the validation.
        $code = $this->codeModel->where('text', '=', $attributes['code'])->firstOrFail();
        unset($attributes["code"]);
        $attributes["code_id"] = $code->id;

        $this->entryModel->create($attributes);
    }
}