<?php

$factory->define(App\Models\User::class, function (Faker\Generator $faker) {
    return [
        'firstname' => $faker->firstName,
        'lastname'  => $faker->lastName,
        'email'     => $faker->safeEmail,
        'password'  => bcrypt(str_random(10)),
        'country'   => $faker->country,
    ];
});
