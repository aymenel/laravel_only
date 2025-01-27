<?php

    namespace Database\Seeders;


    use App\Models\Car;
    use App\Models\User;
    use App\Models\Position;
    use App\Models\Employee;
    use App\Models\CarModel;
    use Illuminate\Support\Arr;
    use App\Models\CarReservation;
    use Illuminate\Database\Seeder;
    use App\Models\ComfortCategory;
    use Illuminate\Database\Eloquent\Collection;

    class DatabaseSeeder extends Seeder
    {

        /**
         * Seed the application's database.
         */
        public function run(): void
        {
            $needleCarModelsCount = 10;
            $needleCarsCount = 20;
            $needleEmployeesCount = 50;
            $needleCarReservationsCount = 20;

            User::factory()->create([ 'name' => 'admin', 'email' => 'admin@admin.ru' ]);

            $comfortCategories = $this->seedComfortCategories();

            $positions = $this->seedPositions($comfortCategories);

            $drivers = $this->seedDrivers($needleCarsCount);

            $carModels = $this->seedCarModels($comfortCategories, $needleCarModelsCount);

            $cars = $this->seedCars($carModels, $drivers, $needleCarsCount);

            $employees = $this->seedEmployees($positions, $needleEmployeesCount);

            $this->seedCarReservations($employees, $cars, $needleCarReservationsCount);
        }

        /**
         * @return Collection<ComfortCategory>
         */
        protected function seedComfortCategories(): Collection
        {
            $comfortCategoryNames = [ 'первая', 'вторая', 'третья', 'четвертая', 'пятая' ];
            $comfortCategories = ComfortCategory::factory(5)
                ->sequence(
                    ...Arr::map($comfortCategoryNames, static fn($item) => [ 'comfort_category_name' => $item ]),
                )
                ->create()
            ;

            return $comfortCategories;
        }

        /**
         * @param Collection<ComfortCategory> $comfortCategories
         * @param int                         $count
         * @return Collection<ComfortCategory>
         */
        protected function seedPositions(Collection $comfortCategories, int $count = 10): Collection
        {
            $positions = Position::factory($count)->create();
            $positions->each(function(Position $position) use ($comfortCategories) {
                $comfortCategoriesCount = random_int(1, 3);
                $comfortCategoriesAdd = $comfortCategories->random($comfortCategoriesCount)->pluck('id')->toArray();

                $position->comfortCategories()->attach($comfortCategoriesAdd);
            });

            return $positions;
        }

        /**
         * @param int $count
         * @return Collection<Employee>
         */
        protected function seedDrivers(int $count = 10): Collection
        {
            $driverPosition = Position::query()->firstOrCreate([ 'position_name' => 'Водитель' ]);
            $driverPosition->comfortCategories()->detach();
            $drivers = Employee::factory($count)->create();

            $drivers->each(function(Employee $driver) use ($driverPosition) {
                $driver->positions()->attach($driverPosition);
            });

            return $drivers;
        }

        /**
         * @param Collection<ComfortCategory> $comfortCategories
         * @param int                         $count
         * @return Collection<CarModel>
         */
        protected function seedCarModels(Collection $comfortCategories, int $count = 10): Collection
        {
            $comfortCategoriesForModels = [];
            while (count($comfortCategoriesForModels) < $count) {
                $comfortCategoriesForModels[] = $comfortCategories->random();
            }
            $carModels = CarModel::factory($count)
                ->sequence(
                    ...Arr::map($comfortCategoriesForModels, static fn($item) => [ 'comfort_category_id' => $item['id'] ]),
                )
                ->create()
            ;

            return $carModels;
        }

        /**
         * @param Collection<CarModel> $carModels
         * @param Collection<Employee> $drivers
         * @param int                  $count
         * @return Collection<Car>
         */
        protected function seedCars(Collection $carModels, Collection $drivers, int $count = 10): Collection
        {
            $carModelsForCar = [];
            while (count($carModelsForCar) < $count) {
                $carModelsForCar[] = $carModels->random()->id;
            }

            $driverIds = $drivers->pluck('id')->toArray();

            $cars = Car::factory($count)
                ->sequence(function ($sequence) use ($carModelsForCar, $driverIds) {
                    return [
                        'car_model_id' => $carModelsForCar[$sequence->index],
                        'driver_id' => $driverIds[$sequence->index]
                    ];
                })
                ->create()
            ;

            return $cars;
        }

        /**
         * @param Collection<Position> $positions
         * @param int                  $count
         * @return Collection<Employee>
         */
        protected function seedEmployees(Collection $positions, int $count = 10): Collection
        {
            $employees = Employee::factory($count)->create();
            $employees->each(function(Employee $employee) use ($positions) {
                $countPositions = (random_int(1, 100) <= 90) ? 1 : 2;
                $positionsAdd = $positions->random($countPositions)->pluck('id')->toArray();

                $employee->positions()->attach($positionsAdd);
            });

            return $employees;
        }

        /**
         * @param Collection<Employee> $employees
         * @param Collection<Car>      $cars
         * @param int                  $count
         * @return Collection<Employee>
         */
        protected function seedCarReservations(Collection $employees, Collection $cars, int $count = 10): Collection
        {
            $employeesForCarReservations = [];
            while (count($employeesForCarReservations) < $count) {
                $employeesForCarReservations[] = $employees->random()->id;
            }
            $carsForCarReservations = [];
            while (count($carsForCarReservations) < $count) {
                $carsForCarReservations[] = $cars->random()->id;
            }

            $carReservations = CarReservation::factory($count)
                ->sequence(function ($sequence) use ($employeesForCarReservations, $carsForCarReservations) {
                    return [
                        'employee_id' => $employeesForCarReservations[$sequence->index],
                        'car_id' => $carsForCarReservations[$sequence->index]
                    ];
                })
                ->create()
            ;

            return $carReservations;
        }

    }
