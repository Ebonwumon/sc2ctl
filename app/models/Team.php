<?php
/**
 * Team
 *
 * @property integer $id
 * @property string $name
 * @property integer $user_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $tag
 * @property string $social_fb
 * @property string $social_twitter
 * @property string $website
 * @property string $logo_url
 * @property string $banner_url
 * @property string $social_twitch
 * @property string $description
 * @property-read \User $user
 * @property-read \Illuminate\Database\Eloquent\Collection|\User[] $members
 * @property-read mixed $qualified_name
 * @property-read \Illuminate\Database\Eloquent\Collection|\Lineup[] $lineups
 * @property-read \Illuminate\Database\Eloquent\Collection|\Match[] $matches
 * @property-read \Illuminate\Database\Eloquent\Collection|\Tournament[] $tournaments
 * @method static \Illuminate\Database\Query\Builder|\Team whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Team whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\Team whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\Team whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Team whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Team whereTag($value)
 * @method static \Illuminate\Database\Query\Builder|\Team whereSocialFb($value)
 * @method static \Illuminate\Database\Query\Builder|\Team whereSocialTwitter($value)
 * @method static \Illuminate\Database\Query\Builder|\Team whereWebsite($value)
 * @method static \Illuminate\Database\Query\Builder|\Team whereLogoUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\Team whereBannerUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\Team whereSocialTwitch($value)
 * @method static \Illuminate\Database\Query\Builder|\Team whereDescription($value)
 */
class Team extends Eloquent { 

	protected $fillable = array('name', 
                              'user_id', 
                              'img_url', 
                              'tag',
                              'description',
                              'social_fb',
                              'social_twitter',
                              'social_twitch',
                              'website',
                              );
	protected $guarded = array('id');

	public function user() {
		return $this->belongsTo('User');
	}

	public function members() {
		return $this->hasMany('User');
	}

  public function getQualifiedNameAttribute() {
    return "[" . $this->tag . "] " . $this->name;
  }

  public function availablePlayers() {
    $players = new Illuminate\Database\Eloquent\Collection;
    foreach ($this->members as $player) {
      if ($player->lineups()->count() == 0) {
        $players->add($player);
      }
    }
    return $players;
  }

	public function lineups() {
		return $this->hasMany('Lineup');
	}

	public function matches() {
		// TOdo will not retun
		return $this->hasMany('Match');
	}

	public function tournaments() {
		return $this->belongsToMany('Tournament');
	}

	//Todo maybe bug from not deleting bnet_ids
	public function userInList($bnet_ids) {
		foreach ($this->members as $member) {
			if (in_array($member->bnet_id, $bnet_ids)) {
				return $member->id;
			}
		}

		return false;
	}

  public function canEditTeam($user) {
    if ($user->hasAccess('edit_teams')) return true;

    //requires team
    if (!$user->team_id) return false;
    if ($user->hasAccess('edit_team')) {
      return ($user->team_id == $this->id);
    }
  }
  
  public function canAddMembers($user) {
    if ($user->hasAccess('add_members')) return true;

    //requires team
    if (!$user->team_id) return false;
    if ($user->hasAccess('add_team_members')) {
      return ($user->team_id == $this->id);
    }
  }

  public function canRemoveMembers($user) {
    if ($user->hasAccess('remove_members')) return true;

    //requires team
    if (!$user->team_id) return false;
    if ($user->hasAccess('remove_team_members')) {
      return ($user->team_id == $this->id);
    }
  }
  
  public function canCreateLineups($user) {
    if ($user->hasAccess('create_lineups')) return true;

    //requires team
    if (!$user->team_id) return false;
    if ($user->hasAccess('create_team_lineups')) {
      return ($user->team_id == $this->id);
    }
  }

  public function canEditLineups($user) {
    if ($user->hasAccess('edit_lineups')) return true;

    //requires team
    if (!$user->team_id) return false;
    if ($user->hasAccess('edit_team_lineups') || $user->hasAccess('edit_team_lineup')) {
      return ($user->team_id == $this->id);
    }
  }


  public function playerSelect() {
    $list = array();
    foreach ($this->members as $user) {
      $list[$user->id] = $user->bnet_name . "#" . $user->char_code;
    }
    return $list;
  }

	public function getMedianWinrate() {
		$arr = array();
		foreach ($this->members as $member) {
			$arr[] = $member->getWinrate()['ratio'];
		}
		if (count($arr) == 0) {
			return 0;
			// We don't want to divide by zero if the team has no members
		}
		sort($arr);
		$median = $arr[ceil(count($arr) / 2) -1];	

		return $median;
	}

	public static function getTBD() {
		$team = new Team;
		$team->name = "TBD";
		$team->tag = "TBD";
		$team->id = 0;
		return $team;
	}

  public static function validate($input) {
    $rules = array(
        'name' => 'sometimes|Required|unique:teams|Between:3,128',
        'tag' => 'sometimes|Required|unique:teams|Between:3,6|alpha',
        'social_fb' => 'sometimes|url',
        'social_twitter' => 'sometimes|url',
        'social_twitch' => 'sometimes|url', 
        'website' => 'sometimes|url'
        );

    return Validator::make($input, $rules);
  }
}
