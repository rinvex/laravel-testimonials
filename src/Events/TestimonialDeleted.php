<?php

declare(strict_types=1);

namespace Rinvex\Testimonials\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Rinvex\Testimonials\Models\Testimonial;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class TestimonialDeleted implements ShouldBroadcast
{
    use SerializesModels;
    use InteractsWithSockets;

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

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel
     */
    public function broadcastOn()
    {
        return new Channel($this->formatChannelName());
    }

    /**
     * The event's broadcast name.
     *
     * @return string
     */
    public function broadcastAs()
    {
        return 'rinvex.testimonials.deleted';
    }

    /**
     * Format channel name.
     *
     * @return string
     */
    protected function formatChannelName(): string
    {
        return 'rinvex.testimonials.list';
    }
}
