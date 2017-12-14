<?php
/**
 * @Author: Guixing Bai
 * @Date:   2017-07-21 13:53:18
 * @Last Modified by:   Guixing Bai
 * @Last Modified time: 2017-07-21 14:02:34
 */

namespace Khsing\Restapi;

use Illuminate\Support\ServiceProvider;

/**
* Resetapi Service Provider
*/
class RestapiServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerConfig();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        if (class_exists('Dingo\Api\Exception\Handler')) {
            app('Dingo\Api\Exception\Handler')->register(function (\Illuminate\Auth\AuthenticationException $exception) {
                return response()->json([
                    'error' => 'Unauthenticated.'
                ], 401);
            });
        }
    }


    /**
     * Register the configuration.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            __DIR__.'/../config/restapi.php' => config_path('restapi.php'),
        ]);
        $this->mergeConfigFrom(realpath(__DIR__.'/../config/restapi.php'), 'restapi');
    }
}
