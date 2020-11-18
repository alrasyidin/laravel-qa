<?php

use Illuminate\Database\Seeder;

class QuestionAndUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\User::class, 10)->create()->each(function($user) {
            $user->questions()->saveMany(factory(App\Question::class, 5)->make());
        });
    }
}
