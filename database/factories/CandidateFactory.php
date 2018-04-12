<?php

use Faker\Generator as Faker;

$factory->define(App\Candidate::class, function (Faker $faker) {
    return [
        'name' => ucwords($faker->sentence(2)),
        'email' => $faker->unique()->safeEmail,
        'photo' => '3G5fkVENrU3Jjj8qiCWmADTeezBPy3ag3CdhoqWT.jpeg',
    ];
});
