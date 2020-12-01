<?php

namespace App;

use App\Question;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function getUrlAttribute()
    {
        // return route('questions.show', $this->slug);

        return '#';
    }

    public function getAvatarAttribute()
    {
        // using gravatar
        // $email = $this->email;
        // $size = 40;

        // return "https://www.gravatar.com/avatar/" . md5( strtolower( trim( $email ) ) ) . "?s=" . $size;

        // using avatar ui
        $background = '0D8ABC';
        $color = 'ffffff';
        $name = $this->name;
        $size = 40;
        $rounded = true;
        return "https://ui-avatars.com/api/?background=$background&name=$name&size=$size&color=$color&rounded=$rounded&font-size=0.35";
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function favorites(){
        return $this->belongsToMany(Question::class, 'favorites')->withTimestamps();
    }

    public function voteQuestions(){
        return $this->morphedByMany(Question::class, 'votable')->withTimestamps();
    }

    public function voteAnswers(){
        return $this->morphedByMany(Answer::class, 'votable')->withTimestamps();
    }

    public function voteQuestion(Question $question, $vote){
        $voteQuestions = $this->voteQuestions();
        
        $this->_vote($voteQuestions, $question, $vote);
    }

    public function voteAnswer(Answer $answer, $vote){
        $voteAnswers = $this->voteAnswers();
        $this->_vote($voteAnswers, $answer, $vote);
    }

    private function _vote($relationship, $model, $vote){
        if($relationship->where('votable_id', $model->id)->exists()){
            $relationship->updateExistingPivot($model, ['vote' => $vote]);
        } else {
            $relationship->attach($model, ['vote' => $vote]);
        }
        
        $model->load('votes');
        $downVotes = (int) $model->votes()->wherePivot('vote', 1)->sum('vote');
        $upVotes = (int) $model->votes()->wherePivot('vote', -1)->sum('vote');

        $model->votes_count = $upVotes + $downVotes;
        $model->save();
    }
}
