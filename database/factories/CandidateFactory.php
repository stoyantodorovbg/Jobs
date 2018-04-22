<?php

use Faker\Generator as Faker;

$factory->define(App\Candidate::class, function (Faker $faker) {
    return [
        'name' => ucwords($faker->sentence(2)),
        'email' => $faker->unique()->safeEmail,
        'photo' => 'yHElSrphbuBCgAEbFnVfPFS2GYgVLIcxXxrR37fV.jpeg',
    ];
});
