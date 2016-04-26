<?php

$factory->define(App\Models\Customer::class, function (Faker\Generator $faker) {
    return [
        'name'        => $faker->name,
        'description' => $faker->text($maxNbChars = 255),
        'email'       => $faker->safeEmail,
    ];
});
