<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(\App\Repositories\EventRepository::class, \App\Repositories\EventRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\UserRepository::class, \App\Repositories\UserRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\RoleRepository::class, \App\Repositories\RoleRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\AttachmentRepository::class, \App\Repositories\AttachmentRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\NoteRepository::class, \App\Repositories\NoteRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\TagRepository::class, \App\Repositories\TagRepositoryEloquent::class);
        //:end-bindings:
    }
}
