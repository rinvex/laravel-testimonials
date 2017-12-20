<?php

declare(strict_types=1);

namespace Rinvex\Testimonials\Traits;

use Illuminate\Database\Eloquent\Model;
use Rinvex\Testimonials\Models\Testimonial;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait TakesTestimonials
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
     * Boot the TakesTestimonials trait for the model.
     *
     * @return void
     */
    public static function bootTakesTestimonials()
    {
        static::deleted(function (self $model) {
            $model->testimonials()->delete();
        });
    }

    /**
     * Get all attached testimonials to the model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function testimonials(): MorphMany
    {
        return $this->morphMany(config('rinvex.testimonials.models.testimonial'), 'subject');
    }

    /**
     * Get testimonials of the given attestant.
     *
     * @param \Illuminate\Database\Eloquent\Model $attestant
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function testimonialsOf(Model $attestant): MorphMany
    {
        return $this->testimonials()->where('attestant_type', $attestant->getMorphClass())->where('attestant_id', $attestant->getKey());
    }

    /**
     * Add new testimonial by the given attestant.
     *
     * @param \Illuminate\Database\Eloquent\Model $attestant
     * @param string                              $body
     *
     * @return \Rinvex\Testimonials\Models\Testimonial
     */
    public function newTestimonial(Model $attestant, string $body): Testimonial
    {
        return $this->testimonials()->create([
            'body' => $body,
            'subject_id' => static::getKey(),
            'subject_type' => static::getMorphClass(),
            'attestant_id' => $attestant->getKey(),
            'attestant_type' => $attestant->getMorphClass(),
        ]);
    }
}
