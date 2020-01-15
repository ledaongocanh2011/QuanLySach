<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
        $this->app->singleton("App\Repositories\BookRepository","App\Repositories\BookRepositoryEloquent");
        $this->app->singleton("App\Repositories\AuthorRepository","App\Repositories\AuthorRepositoryEloquent");
        $this->app->singleton("App\Repositories\UserRepository","App\Repositories\UserRepositoryEloquent");
        $this->app->singleton("App\Repositories\BookUserRepository","App\Repositories\BookUserRepositoryEloquent");
    }
}
