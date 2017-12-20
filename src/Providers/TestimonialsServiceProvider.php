<?php

declare(strict_types=1);

namespace Rinvex\Testimonials\Providers;

use Illuminate\Support\ServiceProvider;
use Rinvex\Testimonials\Contracts\TestimonialContract;
use Rinvex\Testimonials\Console\Commands\MigrateCommand;
use Rinvex\Testimonials\Console\Commands\PublishCommand;
use Rinvex\Testimonials\Console\Commands\RollbackCommand;

class TestimonialsServiceProvider extends ServiceProvider
{
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
        $this->app->singleton('rinvex.testimonials.testimonial', function ($app) {
            return new $app['config']['rinvex.testimonials.models.testimonial']();
        });
        $this->app->alias('rinvex.testimonials.testimonial', TestimonialContract::class);

        // Register console commands
        ! $this->app->runningInConsole() || $this->registerCommands();
    }

    /**
     * {@inheritdoc}
     */
    public function boot()
    {
        // Load migrations
        ! $this->app->runningInConsole() || $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');

        // Publish Resources
        ! $this->app->runningInConsole() || $this->publishResources();
    }

    /**
     * Publish resources.
     *
     * @return void
     */
    protected function publishResources()
    {
        $this->publishes([realpath(__DIR__.'/../../config/config.php') => config_path('rinvex.testimonials.php')], 'rinvex-testimonials-config');
        $this->publishes([realpath(__DIR__.'/../../database/migrations') => database_path('migrations')], 'rinvex-testimonials-migrations');
    }

    /**
     * Register console commands.
     *
     * @return void
     */
    protected function registerCommands()
    {
        // Register artisan commands
        foreach ($this->commands as $key => $value) {
            $this->app->singleton($value, function ($app) use ($key) {
                return new $key();
            });
        }

        $this->commands(array_values($this->commands));
    }
}
