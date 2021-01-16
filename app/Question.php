<?php

namespace App;

use Illuminate\Support\Str;
use Mews\Purifier\Facades\Purifier;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $guarded = [];

    protected $appends = ['created_date', 'body_html', 'is_favorited', 'favorites_count', 'excerpt'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function setTitleAttribute($value){
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }
    
    // clean before input to database
    // public function setBodyAttributes($value){
    //     $this->attributes['body'] = Purifier::clean($value);
    // }

    public function getUrlAttribute(){
        return route('questions.show', $this->slug);
    }

    public function getCreatedDateAttribute(){
        return $this->created_at->diffForHumans();
    }

    public function getStatusAttribute(){
        if($this->answers_count > 0){
            return 'answered';
            if($this->best_answer_id){
                return 'answer-accepted';
            }
        }

        return 'unanswered';
    }

    public function getBodyHtmlAttribute() {
        return Purifier::clean($this->bodyHtml());
    }

    public function bodyHtml() {
        return \Parsedown::instance()->text($this->body);
    }

    public function getExcerptAttribute() {
        return Str::limit(strip_tags($this->bodyHtml()), 240);
    }

    public function answers(){
        return $this->hasMany(Answer::class)->orderBy('votes_count', 'DESC');
    }

    public function acceptBestAnswer(Answer $answer){
        $answer->question->best_answer_id = $answer->id;
        $answer->question->save();
    }

    public function favorites(){
        return $this->belongsToMany(User::class, 'favorites')->withTimestamps();
    }

    public function isFavorited(){
        return $this->favorites()->where('user_id', auth()->id())->count() > 0;
    }

    public function getIsFavoritedAttribute(){
        return $this->isFavorited();
    }

    public function getFavoritesCountAttribute(){
        return $this->favorites()->count();
    }

    public function votes(){
        return $this->morphToMany(User::class, 'votable')->withTimestamps();
    }
}
