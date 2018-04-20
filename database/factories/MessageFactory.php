<?php

use Faker\Generator as Faker;

$factory->define(App\Http\Models\Message::class, function (Faker $faker) {
    return [
        'content' => $faker->sentence(10)
    ];
});