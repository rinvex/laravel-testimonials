<?php

declare(strict_types=1);

return [

    // Manage autoload migrations
    'autoload_migrations' => true,

    // Testimonials Database Tables
    'tables' => [
        'testimonials' => 'testimonials',
    ],

    // Testimonials Models
    'models' => [
        'testimonial' => \Rinvex\Testimonials\Models\Testimonial::class,
    ],

];
