<?php

    namespace Database\Factories;


    use App\Models\ComfortCategory;
    use Illuminate\Database\Eloquent\Factories\Factory;

    /**
     * @extends Factory<ComfortCategory>
     */
    class ComfortCategoryFactory extends Factory
    {

        /**
         * Define the model's default state.
         * @return array<string, mixed>
         */
        public function definition(): array
        {
            return [
                'comfort_category_name' => $this->faker->unique()->word,
            ];
        }

    }
