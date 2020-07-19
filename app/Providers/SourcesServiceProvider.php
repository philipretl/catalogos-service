<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\AuthServiceImpl;
use App\Services\Contracts\AuthService;
use App\Services\Contracts\CompanyService;
use App\Services\CompanyServiceImpl;
use App\Services\Contracts\UserSellerService;
use App\Services\UserSellerServiceImpl;

class SourcesServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(AuthService::class, AuthServiceImpl::class);
        $this->app->bind(CompanyService::class, CompanyServiceImpl::class);
        $this->app->bind(UserSellerService::class, UserSellerServiceImpl::class);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
