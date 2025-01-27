<?php

    namespace Database\Factories;


    use App\Models\CarModel;
    use App\Models\ComfortCategory;
    use Illuminate\Database\Eloquent\Factories\Factory;

    /**
     * @extends Factory<CarModel>
     */
    class CarModelFactory extends Factory
    {

        /**
         * Define the model's default state.
         * @return array<string, mixed>
         */
        public function definition(): array
        {
            return [
                'model_name'          => $this->faker->unique()->randomCar,
                'comfort_category_id' => ComfortCategory::factory(),
            ];
        }

    }
