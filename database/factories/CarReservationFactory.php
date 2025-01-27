<?php

    namespace Database\Factories;


    use App\Models\Car;
    use App\Models\Employee;
    use Illuminate\Support\Carbon;
    use App\Models\CarReservation;
    use Illuminate\Database\Eloquent\Factories\Factory;

    /**
     * @extends Factory<CarReservation>
     */
    class CarReservationFactory extends Factory
    {

        /**
         * Define the model's default state.
         * @return array<string, mixed>
         */
        public function definition(): array
        {
            $startTime = $this->faker->dateTimeInInterval('now', '+30 days');
            $startTime = (Carbon::make($startTime))
                ->setMinutes(0)
                ->setSeconds(0)
            ;

            $endTime = $this->faker->dateTimeInInterval($startTime, '+4 hours');
            $endTime = (Carbon::make($endTime))
                ->setMinutes(0)
                ->setSeconds(0)
            ;

            return [
                'car_id'      => Car::factory(),
                'employee_id' => Employee::factory(),
                'start_time'  => $startTime,
                'end_time'    => $endTime,
            ];
        }

    }
