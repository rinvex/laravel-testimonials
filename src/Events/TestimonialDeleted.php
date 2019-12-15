<?php

declare(strict_types=1);

namespace Rinvex\Testimonials\Events;

use Illuminate\Queue\SerializesModels;
use Rinvex\Testimonials\Models\Testimonial;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class TestimonialDeleted implements ShouldBroadcast
{
    use SerializesModels;

    public $testimonial;

    /**
     * Create a new event instance.
     *
     * @param \Rinvex\Testimonials\Models\Testimonial $testimonial
     */
    public function __construct(Testimonial $testimonial)
    {
        $this->testimonial = $testimonial;
    }
}
