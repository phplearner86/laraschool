<?php

use Faker\Generator as Faker;

$factory->define(App\Event::class, function (Faker $faker) {
    return [
        'teacher_id' => '',
        'subject_id' => '',
        'title' => '',
        'start' => '',
        'end' => '',
    ];
});
