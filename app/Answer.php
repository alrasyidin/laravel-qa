<?php

namespace App;

use Parsedown;
use Mews\Purifier\Facades\Purifier;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $fillable = ['user_id', 'body'];
    protected $appends = ['created_date','body_html', 'is_best'];
    
    public function getBodyHtmlAttribute() {
        return Purifier::clean(Parsedown::instance()->text($this->body));
    }

    public function getCreatedDateAttribute(){
        return $this->created_at->diffForHumans();
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function question(){
        return $this->belongsTo(Question::class);
    }

    public function getStatusAttribute(){
        return $this->isBest() ? 'answer-accepted' : '';
    }

    public function getIsBestAttribute(){
        return $this->isBest();
    }

    public function isBest(){
        return $this->id === $this->question->best_answer_id;
    }

    
    public static function boot(){
        parent::boot();

        static::created(function($answer){
            $answer->question->increment('answers_count');
        });

        static::deleted(function($answer){
            $question = $answer->question;

            $question->decrement('answers_count');
            $question->best_answer_id = NULL;
            $question->save();
        });
    }

    public function votes(){
        return $this->morphToMany(User::class, 'votable')->withTimestamps();
    }
}
