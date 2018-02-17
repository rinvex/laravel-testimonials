<?php

declare(strict_types=1);

namespace Rinvex\Testimonials\Traits;

use Illuminate\Database\Eloquent\Model;
use Rinvex\Testimonials\Models\Testimonial;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait GivesTestimonials
{
    /**
     * Register a deleted model event with the dispatcher.
     *
     * @param \Closure|string $callback
     *
     * @return void
     */
    abstract public static function deleted($callback);

    /**
     * Define a polymorphic one-to-many relationship.
     *
     * @param string $related
     * @param string $name
     * @param string $type
     * @param string $id
     * @param string $localKey
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    abstract public function morphMany($related, $name, $type = null, $id = null, $localKey = null);

    /**
     * Boot the GivesTestimonials trait for the model.
     *
     * @return void
     */
    public static function bootGivesTestimonials()
    {
        static::deleted(function (self $model) {
            $model->recommendations()->delete();
        });
    }

    /**
     * Get all attached testimonials to the model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function recommendations(): MorphMany
    {
        return $this->morphMany(config('rinvex.testimonials.models.testimonial'), 'attestant');
    }

    /**
     * Get recommendations for the given subject.
     *
     * @param \Illuminate\Database\Eloquent\Model $subject
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function recommendationsOf(Model $subject): MorphMany
    {
        return $this->recommendations()->where('subject_type', $subject->getMorphClass())->where('subject_id', $subject->getKey());
    }

    /**
     * Add new testimonial for the given subject.
     *
     * @param \Illuminate\Database\Eloquent\Model $subject
     * @param string                              $body
     *
     * @return \Rinvex\Testimonials\Models\Testimonial
     */
    public function newTestimonial(Model $subject, string $body): Testimonial
    {
        return $this->recommendations()->create([
            'body' => $body,
            'subject_id' => $subject->getKey(),
            'subject_type' => $subject->getMorphClass(),
            'attestant_id' => static::getKey(),
            'attestant_type' => static::getMorphClass(),
        ]);
    }
}
