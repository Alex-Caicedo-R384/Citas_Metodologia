<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\AppointmentRepositoryInterface;
use App\Repositories\EloquentAppointmentRepository;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(AppointmentRepositoryInterface::class, EloquentAppointmentRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
