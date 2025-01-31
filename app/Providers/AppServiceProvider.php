<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\AppointmentRepositoryInterface;
use App\Repositories\EloquentAppointmentRepository;
use App\Factories\ChatFactoryInterface;
use App\Factories\TwoUserChatFactory;
use App\Services\ProfileService;
use App\Repositories\ProfileRepository;


class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(AppointmentRepositoryInterface::class, EloquentAppointmentRepository::class);
        $this->app->bind(ChatFactoryInterface::class, TwoUserChatFactory::class);
        $this->app->singleton(ProfileService::class, function ($app) {
            return new ProfileService(new ProfileRepository());
        });
    }

    public function boot(): void
    {
        //
    }
}
