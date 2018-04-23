<?php

use Faker\Generator as Faker;

$factory->define(App\Job::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence(3),
        'description' => $faker->sentence(12),
        'coordinates' => '42.698334;23.319941',
        'user_id' => rand(1, 5),
    ];
});
