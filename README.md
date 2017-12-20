# Rinvex Testimonials

**Rinvex Testimonials** is a polymorphic Laravel package, for managing testimonials. You can use it however you want, for customers to give testimonials, or for users can give profile recommendations, or any other scenario you imagine.

[![Packagist](https://img.shields.io/packagist/v/rinvex/testimonials.svg?label=Packagist&style=flat-square)](https://packagist.org/packages/rinvex/testimonials)
[![Scrutinizer Code Quality](https://img.shields.io/scrutinizer/g/rinvex/testimonials.svg?label=Scrutinizer&style=flat-square)](https://scrutinizer-ci.com/g/rinvex/testimonials/)
[![Code Climate](https://img.shields.io/codeclimate/github/rinvex/testimonials.svg?label=CodeClimate&style=flat-square)](https://codeclimate.com/github/rinvex/testimonials)
[![Travis](https://img.shields.io/travis/rinvex/testimonials.svg?label=TravisCI&style=flat-square)](https://travis-ci.org/rinvex/testimonials)
[![StyleCI](https://styleci.io/repos/114939264/shield)](https://styleci.io/repos/114939264)
[![License](https://img.shields.io/packagist/l/rinvex/testimonials.svg?label=License&style=flat-square)](https://github.com/rinvex/testimonials/blob/develop/LICENSE)


## Installation

1. Install the package via composer:
    ```shell
    composer require rinvex/testimonials
    ```

2. Execute migrations via the following command:
    ```
    php artisan rinvex:migrate:testimonials
    ```

3. Done!


## Usage

Before goint through the code samples, we need to clarify the concepts behind this package and how it works. **Rinvex Testimonials** assumes that every testimonial has two relationships for two objects, first one is the entity giving the testimonial **(called attestant)**, and second one is the enity receiving it **(called subject)**. These entities could be anything, each and every testimonial stores `type` and `id` (both form a polymorphic relationship) for **subject** and **attestant**. An entity can give testimonials, receive testimonials, or both. It's up to you to decide. 

### Add testimonials functionality to your attestant model

To add support for a model to give testimonials simply use the `\Rinvex\Testimonials\Traits\GivesTestimonials` trait:

```php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Rinvex\Testimonials\Traits\GivesTestimonials;

class User extends Model
{
    use GivesTestimonials;
}
```

### Add testimonials functionality to your subject model

To add support for a model to receive testimonials simply use the `\Rinvex\Testimonials\Traits\TakesTestimonials` trait:

```php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Rinvex\Testimonials\Traits\TakesTestimonials;

class Company extends Model
{
    use TakesTestimonials;
}
```

Both traits could be used together for the same model without any issues.

### Create a new testimonial

Creating a new testimonial is straight forward, and could be done in many ways, use whatever suits your context. Let's see how could we do that:

```php
$user = \App\Models\User::find(1);
$company = \App\Models\Company::find(1);
$testimonial = app('rinvex.testimonials.testimonial');
$testimonialBody = 'I have been using this service as my main learning resource since it went live. I believe it has the best teaching material out there.';

// Create a new testimonial via subject model (attestant, body)
$company->newTestimonial($user, $testimonialBody);

// Create a new testimonial via attestant model (subject, body)
$user->newTestimonial($company, $testimonialBody);

// Create a new testimonial
$testimonial->make(['body' => $testimonialBody])
            ->subject()->associate($company)
            ->attestant()->associate($user)
            ->save();
```

### Query testimonial models

You can get more details about a specific testimonial as follows:

```php
$testimonial = app('rinvex.testimonials.testimonial')->find(1);

$subject = $testimonial->subject; // Get the owning subject model
$user = $testimonial->attestant; // Get the owning attestant model

$company = \App\Models\Company::find(1);
$testimonialsOfSubject = app('rinvex.testimonials.testimonial')->ofSubject($company)->get(); // Get testimonials of the given resource

$user = \App\Models\User::find(1);
$testimonialsOfUser = app('rinvex.testimonials.testimonial')->ofAttestant($user)->get(); // Get testimonials of the given user

$user = \App\Models\User::find(1);
$subject->testimonialsOf($user)->get(); // Get testimonials of the given user

$subject = \App\Models\Subject::find(1);
$user->testimonialsOf($subject)->get(); // Get testimonials by the user for the given subject
```

### Manage testimonials models

And now we can manage our testimonials easliy as follows:

```php
// Find an existing testimonial
$testimonial = app('rinvex.testimonials.testimonial')->find(1);

// Update an existing testimonial
$testimonial->update([
    'body' => 'This service has dramatically helped level up my experience. Those guys knows exactly how to break down advanced topics so they are not overwhelming!',
]);

// Delete testimonial
$testimonial->delete();

// Alternative way of testimonial deletion
$user = \App\Models\User::find(1);
$company = \App\Models\Company::find(1);
$company->testimonials()->where('id', 123)->first()->delete();

$company->testimonials; // Get attached testimonials collection
$user->recommendations; // Get attached recommendations collection

$company->testimonials(); // Get attached testimonials query builder
$company->recommendations(); // Get attached recommendations query builder
```


## Changelog

Refer to the [Changelog](CHANGELOG.md) for a full history of the project.


## Support

The following support channels are available at your fingertips:

- [Chat on Slack](http://chat.rinvex.com)
- [Help on Email](mailto:help@rinvex.com)
- [Follow on Twitter](https://twitter.com/rinvex)


## Contributing & Protocols

Thank you for considering contributing to this project! The contribution guide can be found in [CONTRIBUTING.md](CONTRIBUTING.md).

Bug reports, feature requests, and pull requests are very welcome.

- [Versioning](CONTRIBUTING.md#versioning)
- [Pull Requests](CONTRIBUTING.md#pull-requests)
- [Coding Standards](CONTRIBUTING.md#coding-standards)
- [Feature Requests](CONTRIBUTING.md#feature-requests)
- [Git Flow](CONTRIBUTING.md#git-flow)


## Security Vulnerabilities

If you discover a security vulnerability within this project, please send an e-mail to [help@rinvex.com](help@rinvex.com). All security vulnerabilities will be promptly testimonialed.


## About Rinvex

Rinvex is a software solutions startup, specialized in integrated enterprise solutions for SMEs established in Alexandria, Egypt since June 2016. We believe that our drive The Value, The Reach, and The Impact is what differentiates us and unleash the endless possibilities of our philosophy through the power of software. We like to call it Innovation At The Speed Of Life. That’s how we do our share of advancing humanity.


## License

This software is released under [The MIT License (MIT)](LICENSE).

(c) 2016-2018 Rinvex LLC, Some rights reserved.
