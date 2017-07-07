<?php

namespace aayaresko\Generator;

use Illuminate\Support\ServiceProvider;
use aayaresko\Generator\Commands\API\APIControllerGeneratorCommand;
use aayaresko\Generator\Commands\API\APIGeneratorCommand;
use aayaresko\Generator\Commands\API\APIRequestsGeneratorCommand;
use aayaresko\Generator\Commands\API\TestsGeneratorCommand;
use aayaresko\Generator\Commands\APIScaffoldGeneratorCommand;
use aayaresko\Generator\Commands\Common\MigrationGeneratorCommand;
use aayaresko\Generator\Commands\Common\ModelGeneratorCommand;
use aayaresko\Generator\Commands\Common\RepositoryGeneratorCommand;
use aayaresko\Generator\Commands\Publish\GeneratorPublishCommand;
use aayaresko\Generator\Commands\Publish\LayoutPublishCommand;
use aayaresko\Generator\Commands\Publish\PublishTemplateCommand;
use aayaresko\Generator\Commands\Publish\VueJsLayoutPublishCommand;
use aayaresko\Generator\Commands\RollbackGeneratorCommand;
use aayaresko\Generator\Commands\Scaffold\ControllerGeneratorCommand;
use aayaresko\Generator\Commands\Scaffold\RequestsGeneratorCommand;
use aayaresko\Generator\Commands\Scaffold\ScaffoldGeneratorCommand;
use aayaresko\Generator\Commands\Scaffold\ViewsGeneratorCommand;
use aayaresko\Generator\Commands\VueJs\VueJsGeneratorCommand;

class InfyOmGeneratorServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $configPath = __DIR__.'/../config/laravel_generator.php';

        $this->publishes([
            $configPath => config_path('infyom/laravel_generator.php'),
        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('infyom.publish', function ($app) {
            return new GeneratorPublishCommand();
        });

        $this->app->singleton('infyom.api', function ($app) {
            return new APIGeneratorCommand();
        });

        $this->app->singleton('infyom.scaffold', function ($app) {
            return new ScaffoldGeneratorCommand();
        });

        $this->app->singleton('infyom.publish.layout', function ($app) {
            return new LayoutPublishCommand();
        });

        $this->app->singleton('infyom.publish.templates', function ($app) {
            return new PublishTemplateCommand();
        });

        $this->app->singleton('infyom.api_scaffold', function ($app) {
            return new APIScaffoldGeneratorCommand();
        });

        $this->app->singleton('infyom.migration', function ($app) {
            return new MigrationGeneratorCommand();
        });

        $this->app->singleton('infyom.model', function ($app) {
            return new ModelGeneratorCommand();
        });

        $this->app->singleton('infyom.repository', function ($app) {
            return new RepositoryGeneratorCommand();
        });

        $this->app->singleton('infyom.api.controller', function ($app) {
            return new APIControllerGeneratorCommand();
        });

        $this->app->singleton('infyom.api.requests', function ($app) {
            return new APIRequestsGeneratorCommand();
        });

        $this->app->singleton('infyom.api.tests', function ($app) {
            return new TestsGeneratorCommand();
        });

        $this->app->singleton('infyom.scaffold.controller', function ($app) {
            return new ControllerGeneratorCommand();
        });

        $this->app->singleton('infyom.scaffold.requests', function ($app) {
            return new RequestsGeneratorCommand();
        });

        $this->app->singleton('infyom.scaffold.views', function ($app) {
            return new ViewsGeneratorCommand();
        });

        $this->app->singleton('infyom.rollback', function ($app) {
            return new RollbackGeneratorCommand();
        });

        $this->app->singleton('infyom.vuejs', function ($app) {
            return new VueJsGeneratorCommand();
        });
        $this->app->singleton('infyom.publish.vuejs', function ($app) {
            return new VueJsLayoutPublishCommand();
        });

        $this->commands([
            'infyom.publish',
            'infyom.api',
            'infyom.scaffold',
            'infyom.api_scaffold',
            'infyom.publish.layout',
            'infyom.publish.templates',
            'infyom.migration',
            'infyom.model',
            'infyom.repository',
            'infyom.api.controller',
            'infyom.api.requests',
            'infyom.api.tests',
            'infyom.scaffold.controller',
            'infyom.scaffold.requests',
            'infyom.scaffold.views',
            'infyom.rollback',
            'infyom.vuejs',
            'infyom.publish.vuejs',
        ]);
    }
}
