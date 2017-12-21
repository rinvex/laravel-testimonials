<?php

declare(strict_types=1);

namespace Rinvex\Testimonials\Models;

use Illuminate\Database\Eloquent\Model;
use Rinvex\Cacheable\CacheableEloquent;
use Illuminate\Database\Eloquent\Builder;
use Rinvex\Support\Traits\ValidatingTrait;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Rinvex\Testimonials\Contracts\TestimonialContract;

/**
 * Rinvex\Testimonials\Models\Testimonial.
 *
 * @property int                                                                             $id
 * @property int                                                                             $user_id
 * @property bool                                                                            $is_approved
 * @property string                                                                          $body
 * @property \Carbon\Carbon|null                                                             $created_at
 * @property \Carbon\Carbon|null                                                             $updated_at
 * @property \Carbon\Carbon|null                                                             $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent                              $user
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Testimonials\Models\Testimonial approved()
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Testimonials\Models\Testimonial disapproved()
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Testimonials\Models\Testimonial whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Testimonials\Models\Testimonial whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Testimonials\Models\Testimonial whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Testimonials\Models\Testimonial whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Testimonials\Models\Testimonial whereIsApproved($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Testimonials\Models\Testimonial whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Testimonials\Models\Testimonial whereUserId($value)
 * @mixin \Eloquent
 */
class Testimonial extends Model implements TestimonialContract
{
    use ValidatingTrait;
    use CacheableEloquent;

    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'user_id',
        'is_approved',
        'body',
    ];

    /**
     * {@inheritdoc}
     */
    protected $casts = [
        'user_id' => 'integer',
        'is_approved' => 'boolean',
        'body' => 'string',
        'deleted_at' => 'datetime',
    ];

    /**
     * {@inheritdoc}
     */
    protected $observables = [
        'validating',
        'validated',
    ];

    /**
     * The default rules that the model will validate against.
     *
     * @var array
     */
    protected $rules = [
        'user_id' => 'required|integer',
        'is_approved' => 'sometimes|boolean',
        'body' => 'required|string|max:150',
    ];

    /**
     * Whether the model should throw a
     * ValidationException if it fails validation.
     *
     * @var bool
     */
    protected $throwValidationExceptions = true;

    /**
     * Create a new Eloquent model instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->setTable(config('rinvex.testimonials.tables.testimonials'));
    }

    /**
     * Get the approved testimonials.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeApproved(Builder $builder): Builder
    {
        return $builder->where('is_approved', true);
    }

    /**
     * Get the disapproved testimonials.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeDisapproved(Builder $builder): Builder
    {
        return $builder->where('is_approved', false);
    }

    /**
     * Get the owner model of the testimonial.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): belongsTo
    {
        return $this->belongsTo(config('auth.providers.users.model'), 'user_id', 'id');
    }

    /**
     * Approve the testimonial.
     *
     * @return $this
     */
    public function approve()
    {
        $this->update(['is_approved' => true]);

        return $this;
    }

    /**
     * Disapprove the testimonial.
     *
     * @return $this
     */
    public function disapprove()
    {
        $this->update(['is_approved' => false]);

        return $this;
    }
}
