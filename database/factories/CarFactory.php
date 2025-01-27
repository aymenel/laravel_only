<?php

    namespace Database\Factories;


    use App\Models\Car;
    use App\Models\CarModel;
    use App\Models\Employee;
    use Illuminate\Database\Eloquent\Factories\Factory;

    /**
     * @extends Factory<Car>
     */
    class CarFactory extends Factory
    {

        /**
         * Define the model's default state.
         * @return array<string, mixed>
         */
        public function definition(): array
        {
            return [
                'number'       => $this->faker->unique()->randomCarNumber,
                'car_model_id' => CarModel::factory(),
                'driver_id'    => Employee::factory(),
            ];
        }

    }
