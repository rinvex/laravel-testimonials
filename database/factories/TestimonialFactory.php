<?php

declare(strict_types=1);

use Faker\Generator as Faker;

$factory->define(Rinvex\Testimonials\Models\Testimonial::class, function (Faker $faker) {
    return [
        'attestant_id' => $faker->randomNumber(),
        'attestant_type' => $faker->randomElement(['App\Models\Member', 'App\Models\Manager', 'App\Models\Admin']),
        'subject_id' => $faker->randomNumber(),
        'subject_type' => $faker->randomElement(['App\Models\Company', 'App\Models\Product', 'App\Models\User']),
        'is_approved' => $faker->boolean,
        'body' => $faker->paragraph,
    ];
});
