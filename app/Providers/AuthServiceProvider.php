<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
        'App\Question' => 'App\Policies\QuestionPolicy',
        'App\Answer' => 'App\Policies\AnswerPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // define passport routes
        Passport::routes();
        
        // Gate::define('update-question', function($user, $question){
        //     return $user->id === $question->user_id;
        // });

        // Gate::define('delete-question', function($user, $question){
        //     return $user->id === $question->user_id;
        // });
    }
}
