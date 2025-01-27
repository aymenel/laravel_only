<?php

    namespace App\Providers;


    use App\Repositories\CarRepository;
    use App\Repositories\CarModelRepository;
    use Illuminate\Support\ServiceProvider;
    use App\Repositories\EmployeeRepository;
    use App\Repositories\PositionRepository;
    use App\Interfaces\CarRepositoryInterface;
    use App\Interfaces\CarModelRepositoryInterface;
    use App\Repositories\ComfortCategoryRepository;
    use App\Interfaces\EmployeeRepositoryInterface;
    use App\Interfaces\PositionRepositoryInterface;
    use App\Interfaces\ComfortCategoryRepositoryInterface;

    class RepositoryServiceProvider extends ServiceProvider
    {

        public function register()
        {
            $this->app->bind(
                CarModelRepositoryInterface::class,
                CarModelRepository::class,
            );
            $this->app->bind(
                ComfortCategoryRepositoryInterface::class,
                ComfortCategoryRepository::class,
            );
            $this->app->bind(
                EmployeeRepositoryInterface::class,
                EmployeeRepository::class,
            );
            $this->app->bind(
                PositionRepositoryInterface::class,
                PositionRepository::class,
            );
            $this->app->bind(
                CarRepositoryInterface::class,
                CarRepository::class,
            );
        }

    }
