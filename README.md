# Rinvex Testimonials

This package is NOT actively maintained! Want to jump in as a maintainer? Ping me [@omranic](https://twitter.com/omranic)


**Rinvex Testimonials** is a polymorphic Laravel package for managing testimonials. Customers can give you testimonials, and you can approve or disapprove each individually. Testimonials are good for showing the passion and love your service gets from customers, encouraging others to join the hype!

[![Packagist](https://img.shields.io/packagist/v/rinvex/laravel-testimonials.svg?label=Packagist&style=flat-square)](https://packagist.org/packages/rinvex/laravel-testimonials)
[![Scrutinizer Code Quality](https://img.shields.io/scrutinizer/g/rinvex/laravel-testimonials.svg?label=Scrutinizer&style=flat-square)](https://scrutinizer-ci.com/g/rinvex/laravel-testimonials/)
[![Travis](https://img.shields.io/travis/rinvex/laravel-testimonials.svg?label=TravisCI&style=flat-square)](https://travis-ci.org/rinvex/laravel-testimonials)
[![StyleCI](https://styleci.io/repos/114939264/shield)](https://styleci.io/repos/114939264)
[![License](https://img.shields.io/packagist/l/rinvex/laravel-testimonials.svg?label=License&style=flat-square)](https://github.com/rinvex/laravel-testimonials/blob/develop/LICENSE)


## Installation

1. Install the package via composer:
    ```shell
    composer require rinvex/laravel-testimonials
    ```

2. Publish resources (migrations and config files):
    ```shell
    php artisan rinvex:publish:testimonials
    ```

3. Execute migrations via the following command:
    ```shell
    php artisan rinvex:migrate:testimonials
    ```

4. Done!


## Usage

Before going through the code samples, we need to clarify the concepts behind this package and how it works. **Rinvex Testimonials** assumes that every testimonial has two relationships, the is the entity giving the testimonial **(called attestant)**, and second is the enity receiving it **(called subject)**. These entities could be anything, each and every testimonial stores `type` and `id` (both form a polymorphic relationship) for **subject** and **attestant**. An entity can give testimonials, receive testimonials, or both. It's up to you to decide. 

### Add giving testimonials functionality to your model

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

### Add receiving testimonials functionality to your model

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

// Create a new testimonial explicitly
$testimonial->make(['body' => $testimonialBody])
            ->subject()->associate($company)
            ->attestant()->associate($user)
            ->save();
```

### Query testimonial models

You can get more details about a specific testimonial as follows:

```php
$testimonial = app('rinvex.testimonials.testimonial')->find(1);

$company = $testimonial->subject; // Get the owning company model
$user = $testimonial->attestant; // Get the owning user model

$testimonialsOfCompany = app('rinvex.testimonials.testimonial')->ofSubject($company)->get(); // Get testimonials of the given company
$recommendationsOfUser = app('rinvex.testimonials.testimonial')->ofAttestant($user)->get(); // Get testimonials of the given user

$company->testimonialsOf($user)->get(); // Get testimonials of the given user
$user->recommendationsOf($company)->get(); // Get testimonials by the user for the given company

$user->recommendations; // Get given testimonials collection
$user->recommendations(); // Get given testimonials query builder

$company->testimonials; // Get received testimonials collection
$company->testimonials(); // Get received testimonials query builder
```

And not surprisingly, the `\Rinvex\Testimonials\Models\Testimonial` model itself extends [Eloquent](https://laravel.com/docs/master/eloquent) so you can manage it fluently as you normally do.


## Changelog

Refer to the [Changelog](CHANGELOG.md) for a full history of the project.


## Support

The following support channels are available at your fingertips:

- [Chat on Slack](https://bit.ly/rinvex-slack)
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

(c) 2016-2021 Rinvex LLC, Some rights reserved.
