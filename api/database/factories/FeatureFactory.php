<?php

$factory->define(App\Models\Feature::class, function (Faker\Generator $faker) {
    return [
        'name'         => $faker->name,
        'display_name' => $faker->name,
        'description'  => $faker->text($maxNbChars = 255),
    ];
});
