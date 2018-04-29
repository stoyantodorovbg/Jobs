<?php

use Faker\Generator as Faker;

$factory->define(App\Http\Models\Advertisement::class, function (Faker $faker) {
    return [
        'author_name' => $faker->sentence(3),
        'author_email' => $faker->unique()->safeEmail,
        'title' => $faker->sentence(1),
        'description' => $faker->sentence(2),
        'content' => $faker->sentence(12),
    ];
});
