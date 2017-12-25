# Rinvex Testimonials

**Rinvex Testimonials** is a Laravel package for managing testimonials. Customers can give you testimonials, and you can approve or disapprove each individually. Testimonials are good for showing the passion and love your service gets from customers, encouraging others to join the hype!

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

To add testimonials support to your eloquent models simply use `\Rinvex\Testimonials\Traits\HasTestimonials` trait.

### Create a new testimonial

Creating a new testimonial is straight forward, and could be done in many ways, use whatever suits your context. Let's see how could we do that:

```php
$user = \App\Models\User::find(1);
$testimonial = app('rinvex.testimonials.testimonial');
$testimonialBody = 'I have been using this service as my main learning resource since it went live. I believe it has the best teaching material out there.';

// These are three different ways to add a new testimonial, and get the same result
$user->testimonials()->save($testimonial->fill(['body' => $testimonialBody]));
$testimonial->create(['user_id' => $user->id, 'body' => $testimonialBody]);
$user->testimonials()->create(['body' => $testimonialBody]);
```

### Query testimonial models

You can get more details about a specific testimonial as follows:

```php
$testimonial = app('rinvex.testimonials.testimonial')->find(1);

$user = $testimonial->user; // Get the owning user model
$user->testimonials; // Get attached testimonials collection
$user->testimonials(); // Get attached testimonials query builder
```

And as you may have expected, the underlying `\Rinvex\Testimonials\Models\Testimonial` model extends [Eloquent](https://laravel.com/docs/master/eloquent) so you can manage these models fluently as you normally do.


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
