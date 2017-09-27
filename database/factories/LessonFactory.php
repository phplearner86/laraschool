<?php

use Faker\Generator as Faker;

$factory->define(App\Lesson::class, function (Faker $faker) {
    return [
        'teacher_id' => '',
        'subject_id' => '',
        'year' => '',
        'title' => '',
    ];
});
