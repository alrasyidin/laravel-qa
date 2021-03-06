<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Question;
use Faker\Generator as Faker;

$factory->define(Question::class, function (Faker $faker) {
    return [
        "title" => rtrim($faker->sentence(), '.'),
        "body" => $faker->paragraphs(rand(4, 10), true),
        "views" => rand(3, 10),
        // "answers_count" => rand(3, 10),
        "votes_count" => rand(-10, 10),
    ];
});
