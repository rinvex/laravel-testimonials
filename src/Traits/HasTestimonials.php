<?php

declare(strict_types=1);

namespace Rinvex\Testimonials\Traits;

use Illuminate\Database\Eloquent\Relations\HasMany;

trait HasTestimonials
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
     * Define a one-to-many relationship.
     *
     * @param  string  $related
     * @param  string  $foreignKey
     * @param  string  $localKey
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    abstract public function hasMany($related, $foreignKey = null, $localKey = null);

    /**
     * Boot the HasTestimonials trait for the model.
     *
     * @return void
     */
    public static function bootHasTestimonials()
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
    public function testimonials(): HasMany
    {
        return $this->hasMany(config('rinvex.testimonials.models.testimonial'), 'user_id', 'id');
    }
}
