<?php

    namespace Database\Factories;


    use App\Models\User;
    use App\Models\Employee;
    use Illuminate\Database\Eloquent\Factories\Factory;

    /**
     * @extends Factory<Employee>
     */
    class EmployeeFactory extends Factory
    {

        /**
         * Define the model's default state.
         * @return array<string, mixed>
         */
        public function definition(): array
        {
            $fullName = $this->faker->name();
            $explodedName = explode(' ', $fullName);

            $surname = array_shift($explodedName);
            $name = array_shift($explodedName);
            $patronymic = array_shift($explodedName);

            return [
                'surname'    => $surname,
                'name'       => $name,
                'patronymic' => $patronymic,
                'user_id'    => User::factory(['name' => $fullName]),
            ];
        }

    }
