<?php

namespace Lameck\Manuser;

use Illuminate\Support\ServiceProvider;
use Lameck\Manuser\ManuserController;

class ManuserServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        include __DIR__.'../../../../../routes/api.php';
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {    
        $this->app->make('Lameck\Manuser\ManuserController');
        include __DIR__.'/routes.php';
        include __DIR__.'/ThrottleRequestsMiddleware.php';
    }
}
