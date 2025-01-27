<?php

    namespace App\Providers;


    use Faker\Factory;
    use Faker\Generator;
    use App\Faker\CarProvider;
    use App\Faker\PositionProvider;
    use App\Faker\CarNumberProvider;
    use Illuminate\Support\ServiceProvider;

    class FakerServiceProvider extends ServiceProvider
    {

        public function register(): void
        {
            //
        }

        public function boot(): void
        {
            $this->app->afterResolving(Generator::class, function (Generator $faker) {
                $faker->addProvider(new CarProvider(Factory::create()));
                $faker->addProvider(new CarNumberProvider(Factory::create()));
                $faker->addProvider(new PositionProvider(Factory::create()));
            });
        }

    }
