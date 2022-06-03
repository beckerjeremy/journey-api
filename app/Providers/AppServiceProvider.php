<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (env('APP_ENV') === 'production') {
            $this->app['request']->server->set('HTTPS', true);
        }

        Validator::extend('poly_exists', function ($attribute, $value, $parameters, $validator) {
            if (!$objectType = array_get($validator->getData(), $parameters[0], false)) {
                return false;
            }
        
            return !empty(resolve($objectType)->find($value));
        });

        $request = app('request');
        if ($request->isMethod('OPTIONS')) {
            app()->options($request->path(), function() { return response('', 200); });
        }
    }
}
