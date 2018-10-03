<?php

namespace Modules\Core\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Core\Interfaces\SyncInterface;
use Modules\Core\Services\CalendarSync;
use Modules\Core\Services\Test;
use Modules\Calendar\Repositories\CalendarRepository;
use Modules\User\Repositories\UserRepository;
use Modules\Package\Repositories\PackageRepository;
use Modules\Package\Repositories\SessionRepository;

class SyncServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    protected $calendar;

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('SyncService', function ($app) {
            return new CalendarSync(
                $app->make(CalendarRepository::class),
                $app->make(UserRepository::class),
                $app->make(PackageRepository::class),
                $app->make(SessionRepository::class)
            );
        });
    }
}
