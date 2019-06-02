<?php

declare(strict_types=1);

namespace Rinvex\Testimonials\Providers;

use Illuminate\Support\ServiceProvider;
use Rinvex\Support\Traits\ConsoleTools;
use Rinvex\Testimonials\Models\Testimonial;
use Rinvex\Testimonials\Console\Commands\MigrateCommand;
use Rinvex\Testimonials\Console\Commands\PublishCommand;
use Rinvex\Testimonials\Console\Commands\RollbackCommand;

class TestimonialsServiceProvider extends ServiceProvider
{
    use ConsoleTools;

    /**
     * The commands to be registered.
     *
     * @var array
     */
    protected $commands = [
        MigrateCommand::class => 'command.rinvex.testimonials.migrate',
        PublishCommand::class => 'command.rinvex.testimonials.publish',
        RollbackCommand::class => 'command.rinvex.testimonials.rollback',
    ];

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        // Merge config
        $this->mergeConfigFrom(realpath(__DIR__.'/../../config/config.php'), 'rinvex.testimonials');

        // Bind eloquent models to IoC container
        $this->app->singleton('rinvex.testimonials.testimonial', $testimonialModel = $this->app['config']['rinvex.testimonials.models.testimonial']);
        $testimonialModel === Testimonial::class || $this->app->alias('rinvex.testimonials.testimonial', Testimonial::class);

        // Register console commands
        ! $this->app->runningInConsole() || $this->registersCommands();
    }

    /**
     * {@inheritdoc}
     */
    public function boot()
    {
        // Publish Resources
        ! $this->app->runningInConsole() || $this->publishesConfig('rinvex/laravel-testimonials');
        ! $this->app->runningInConsole() || $this->publishesMigrations('rinvex/laravel-testimonials');
    }
}
