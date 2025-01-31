<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\AppointmentRepositoryInterface;
use App\Repositories\EloquentAppointmentRepository;
use App\Factories\ChatFactoryInterface;
use App\Factories\TwoUserChatFactory;


class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(AppointmentRepositoryInterface::class, EloquentAppointmentRepository::class);
        $this->app->bind(ChatFactoryInterface::class, TwoUserChatFactory::class);
    }

    public function boot(): void
    {
        //
    }
}
