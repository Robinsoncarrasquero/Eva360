<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use Egulias\EmailValidator\EmailValidator;
use Egulias\EmailValidator\Validation\DNSCheckValidation;
use Illuminate\Support\Facades\Schema;
use Illuminate\Pagination\Paginator;


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

        $this->app->singleton(
            'configuracion',
            \App\CustomClass\ConfigSingleton::class
        );

        Validator::extend('check_email_dns', function ($attribute, $value, $parameters, $validator) {
            return (new EmailValidator())->isValid($value, new DNSCheckValidation());
        });

        Schema::defaultStringLength(191);
        //mantiene paginacion con bootstrap no con tailwind
        Paginator::useBootstrap();
    }
}
