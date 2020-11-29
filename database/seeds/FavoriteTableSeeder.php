<?php

use App\User;
use App\Question;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FavoriteTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('favorites')->delete();
        $users = User::all();
        $questions = Question::pluck('id')->all();

        foreach ($users as $user) {
            for ($i=0; $i < rand(1, count($questions)); $i++) { 
                $user->favorites()->attach($questions[$i]);
            }
        }
    }
}
