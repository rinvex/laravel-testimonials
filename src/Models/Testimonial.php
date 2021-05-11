<?php

declare(strict_types=1);

namespace Rinvex\Testimonials\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Rinvex\Support\Traits\ValidatingTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * Rinvex\Testimonials\Models\Testimonial.
 *
 * @property int                 $id
 * @property int                 $subject_id
 * @property string              $subject_type
 * @property int                 $attestant_id
 * @property string              $attestant_type
 * @property bool                $is_approved
 * @property string              $body
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent                              $attestant
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent                              $subject
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Testimonials\Models\Testimonial approved()
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Testimonials\Models\Testimonial disapproved()
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Testimonials\Models\Testimonial whereAttestantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Testimonials\Models\Testimonial whereAttestantType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Testimonials\Models\Testimonial whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Testimonials\Models\Testimonial whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Testimonials\Models\Testimonial whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Testimonials\Models\Testimonial whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Testimonials\Models\Testimonial whereIsApproved($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Testimonials\Models\Testimonial whereSubjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Testimonials\Models\Testimonial whereSubjectType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Testimonials\Models\Testimonial whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Testimonial extends Model
{
    use SoftDeletes;
    use ValidatingTrait;

    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'subject_id',
        'subject_type',
        'attestant_id',
        'attestant_type',
        'is_approved',
        'body',
    ];

    /**
     * {@inheritdoc}
     */
    protected $casts = [
        'subject_id' => 'integer',
        'subject_type' => 'string',
        'attestant_id' => 'integer',
        'attestant_type' => 'string',
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
    protected $rules = [];

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
        $this->setTable(config('rinvex.testimonials.tables.testimonials'));
        $this->setRules([
            'subject_id' => 'required|integer',
            'subject_type' => 'required|string|strip_tags|max:150',
            'attestant_id' => 'required|integer',
            'attestant_type' => 'required|string|strip_tags|max:150',
            'is_approved' => 'sometimes|boolean',
            'body' => 'required|string|strip_tags|max:150',
        ]);

        parent::__construct($attributes);
    }

    /**
     * Get testimonials of the given subject.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @param \Illuminate\Database\Eloquent\Model   $subject
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfSubject(Builder $builder, Model $subject): Builder
    {
        return $builder->where('subject_type', $subject->getMorphClass())->where('subject_id', $subject->getKey());
    }

    /**
     * Get testimonials of the given attestant.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @param \Illuminate\Database\Eloquent\Model   $attestant
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfAttestant(Builder $builder, Model $attestant): Builder
    {
        return $builder->where('attestant_type', $attestant->getMorphClass())->where('attestant_id', $attestant->getKey());
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
     * Get the subject model of the testimonial.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function subject(): MorphTo
    {
        return $this->morphTo('subject', 'subject_type', 'subject_id', 'id');
    }

    /**
     * Get the attestant model of the testimonial.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function attestant(): MorphTo
    {
        return $this->morphTo('attestant', 'attestant_type', 'attestant_id', 'id');
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
