<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(Janitor\Models\User::class, function (Faker\Generator $faker) {
    return [
        'firstname' => $faker->firstName,
        'lastname' => $faker->lastName,
        'email' => $faker->unique()->safeEmail,
        'password' => str_random(20),
        'photo' => str_random(10).'.jpg',
        'remember_token' => str_random(10),
    ];
});

$factory->define(Janitor\Models\PostCategory::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->sentence,
        'slug' => $faker->sentence,
        'description' => $faker->paragraph
    ];
});