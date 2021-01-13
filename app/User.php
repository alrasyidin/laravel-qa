<?php

namespace App;

use App\Question;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

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

    protected $appends = [ 'url', 'avatar' ];

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

    public function posts($type)
    {
        if ($type === 'questions') {
            $posts = $this->questions()->get();
        } else if ($type === 'answer') {
            $posts = $this->answers()->with('question')->get();
        } else {
           $postQuestions = $this->questions()->get();
           $postAnswers = $this->answers()->with('question')->get();

           $posts = $postQuestions->merge($postAnswers);
        }
        $data = collect();

        foreach ($posts as $post ) {
            $item = [
                'votes_count' => $post->votes_count,
                'created_at' => $post->created_at->format('M d Y')
            ];

            if ($post instanceof Question) {
                $item['type'] = 'Q';
                $item['title'] = $post->title;
                $item['accepted'] = (bool) $post->best_answer_id;
            }
            elseif ($post instanceof Answer) {
                $item['type'] = 'A';
                $item['title'] = $post->question->title;
                $item['accepted'] = $post->question->best_answer_id === $post->id ? true : false;;
            }

            $data->push($item);
        }
        return $data->sortByDesc("votes_count")->values()->all();
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
        
        return $this->_vote($voteQuestions, $question, $vote);
    }

    public function voteAnswer(Answer $answer, $vote){
        $voteAnswers = $this->voteAnswers();
        return $this->_vote($voteAnswers, $answer, $vote);
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

        return $model->votes_count;
    }
}
