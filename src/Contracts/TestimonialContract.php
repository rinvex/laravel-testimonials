<?php

declare(strict_types=1);

namespace Rinvex\Testimonials\Contracts;

/**
 * Rinvex\Testimonials\Contracts\TestimonialContract.
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
interface TestimonialContract
{
    //
}
