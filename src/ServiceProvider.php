<?php

/*
 * preset: symfony
 */

namespace Renfan\Face;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    protected $defer = true;

    public function register()
    {
        $configPath = __DIR__.'/config/config.php';

        $this->mergeConfigFrom($configPath, 'face');
        $this->publishes([
            $configPath => config_path('face.php'),
        ], 'config');

        $this->app->singleton(Face::class, function () {
            return new Face(config('face.key'), config('face.secret'));
        });

        $this->app->alias(Face::class, 'face');
    }

    public function provides()
    {
        return [Face::class, 'face'];
    }
}
