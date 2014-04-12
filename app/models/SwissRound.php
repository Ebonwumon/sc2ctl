<?php

/**
 * SwissRound
 *
 * @property integer $id
 * @property integer $tournament_id
 * @property string $due_date
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Match[] $matches
 * @property-read \Tournament $tournament
 * @method static \Illuminate\Database\Query\Builder|\SwissRound whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\SwissRound whereTournamentId($value)
 * @method static \Illuminate\Database\Query\Builder|\SwissRound whereDueDate($value)
 * @method static \Illuminate\Database\Query\Builder|\SwissRound whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\SwissRound whereUpdatedAt($value)
 */
class SwissRound extends Eloquent {
  
  protected $guarded = array('id');
  protected $fillable = array('due_date', 'tournament_id');

  public function matches() {
    return $this->hasMany('Match');
  }

  public function tournament() {
    return $this->belongsTo('Tournament');
  }

    /**
     * Summarizes the results of the current Swiss Round by giving a full breakdown of wins/losses for each team.
     * @return SwissRoundScore[]
     */
    public function summarize() {
    $summary = array();
    foreach ($this->matches as $match) {
      foreach ($match->score() as $k => $v) {
        $summary[] = new SwissRoundScore($k, $v['wins'], $v['losses']);
      }
    }
    return $summary;
  }
}
