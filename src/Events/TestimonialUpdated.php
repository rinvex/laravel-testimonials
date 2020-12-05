<?php

declare(strict_types=1);

namespace Rinvex\Testimonials\Events;

use Rinvex\Testimonials\Models\Testimonial;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class TestimonialUpdated implements ShouldBroadcast
{
    use InteractsWithSockets;
    use SerializesModels;
    use Dispatchable;

    /**
     * The name of the queue on which to place the event.
     *
     * @var string
     */
    public $broadcastQueue = 'events';

    /**
     * The model instance passed to this event.
     *
     * @var \Rinvex\Testimonials\Models\Testimonial
     */
    public Testimonial $model;

    /**
     * Create a new event instance.
     *
     * @param \Rinvex\Testimonials\Models\Testimonial $testimonial
     */
    public function __construct(Testimonial $testimonial)
    {
        $this->model = $testimonial;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|\Illuminate\Broadcasting\Channel[]
     */
    public function broadcastOn()
    {
        return [
            new PrivateChannel('rinvex.testimonials.testimonials.index'),
            new PrivateChannel("rinvex.testimonials.testimonials.{$this->model->getRouteKey()}"),
        ];
    }

    /**
     * The event's broadcast name.
     *
     * @return string
     */
    public function broadcastAs()
    {
        return 'testimonial.updated';
    }
}
