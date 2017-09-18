<?php

use Faker\Generator as Faker;

$factory->define(App\Classroom::class, function (Faker $faker) {
    return [
        'label' => str_random(2)
    ];
});
