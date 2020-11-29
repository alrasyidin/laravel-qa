<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuestionAndUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('questions')->delele();
        DB::table('answer')->delele();
        DB::table('users')->delele();

        factory(App\User::class, 10)
            ->create()
            ->each(function ($user) {
                $user->questions()
                    ->saveMany(factory(App\Question::class, 5)->make())
                    ->each(function ($question) {
                        $question->answers()
                                 ->saveMany( factory(App\Answer::class, rand(1, 10))->make() );
                    });
            });
    }
}
