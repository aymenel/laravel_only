<?php

    namespace App\Providers;


    use App\Services\CarService;
    use Illuminate\Support\ServiceProvider;
    use App\Interfaces\CarServiceInterface;

    class AppServiceProvider extends ServiceProvider
    {

        /**
         * Register any application services.
         */
        public function register(): void
        {
            $this->app->bind(
                CarServiceInterface::class,
                CarService::class,
            );
        }

        /**
         * Bootstrap any application services.
         */
        public function boot(): void
        {
            //
        }

    }
