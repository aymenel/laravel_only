<?php

    namespace Tests\Feature;


    use Tests\TestCase;
    use App\Models\Car;
    use App\Models\User;
    use App\Models\Position;
    use App\Models\Employee;
    use App\Models\CarModel;
    use App\Models\CarReservation;
    use App\Models\ComfortCategory;
    use Illuminate\Foundation\Testing\RefreshDatabase;

    class CarAvailabilityTest extends TestCase
    {

        use RefreshDatabase;

        protected Employee $employee;

        protected ComfortCategory $comfortCategory;

        protected CarModel $carModel;

        /**
         * @noinspection PhpPossiblePolymorphicInvocationInspection
         */
        public function test_returns_available_cars_for_employee(): void
        {
            $availableCar = Car::factory()->create([ 'car_model_id' => $this->carModel->id ]);
            $unavailableCar = Car::factory()->create();

            $response = $this->actingAs($this->employee->user)
                ->json('GET', '/api/v1/available-cars', [
                    'start_time' => now()->addHour()->toDateTimeString(),
                    'end_time'   => now()->addHours(2)->toDateTimeString(),
                ])
            ;

            $response->assertStatus(200)
                ->assertJsonCount(1)
                ->assertJsonFragment([ 'number' => $availableCar->number ])
                ->assertJsonMissing([ 'number' => $unavailableCar->number ])
            ;
        }

        /**
         * @noinspection PhpPossiblePolymorphicInvocationInspection
         */
        public function test_excludes_reserved_cars(): void
        {
            $car = Car::factory()->create([ 'car_model_id' => $this->carModel->id ]);

            CarReservation::factory()->create([
                'car_id'     => $car->id,
                'start_time' => now()->addHour(),
                'end_time'   => now()->addHours(3),
            ]);

            $response = $this->actingAs($this->employee->user)
                ->json('GET', '/api/v1/available-cars', [
                    'start_time' => now()->addHours(2)->toDateTimeString(),
                    'end_time'   => now()->addHours(4)->toDateTimeString(),
                ])
            ;

            $response->assertJsonCount(0);
        }

        /**
         * @noinspection PhpPossiblePolymorphicInvocationInspection
         */
        public function test_filters_cars_by_model(): void
        {
            Car::factory()->create([
                'car_model_id' => $this->carModel->id,
                'number'       => 'а 123 вв 170',
            ]);

            $anotherModel = CarModel::factory()->create([
                'comfort_category_id' => $this->comfortCategory->id,
                'model_name'          => 'Audi A8',
            ]);
            Car::factory()->create([ 'car_model_id' => $anotherModel->id ]);

            $response = $this->actingAs($this->employee->user)
                ->json('GET', '/api/v1/available-cars', [
                    'start_time'   => now()->addHour()->toDateTimeString(),
                    'end_time'     => now()->addHours(2)->toDateTimeString(),
                    'car_model_id' => $this->carModel->id,
                ])
            ;

            $response->assertJsonCount(1)
                ->assertJsonFragment([ 'number' => 'а 123 вв 170' ])
            ;
        }

        /**
         * @noinspection PhpPossiblePolymorphicInvocationInspection
         */
        public function test_filters_cars_by_comfort_category(): void
        {
            $car = Car::factory()->create([ 'car_model_id' => $this->carModel->id ]);

            $anotherCategory = ComfortCategory::factory()->create([ 'comfort_category_name' => 'Luxury' ]);
            $anotherModel = CarModel::factory()->create([ 'comfort_category_id' => $anotherCategory->id ]);
            Car::factory()->create([ 'car_model_id' => $anotherModel->id ]);

            $response = $this->actingAs($this->employee->user)
                ->json('GET', '/api/v1/available-cars', [
                    'start_time'          => now()->addHour()->toDateTimeString(),
                    'end_time'            => now()->addHours(2)->toDateTimeString(),
                    'comfort_category_id' => $this->comfortCategory->id,
                ])
            ;

            $response->assertJsonCount(1)
                ->assertJsonFragment([ 'number' => $car->number ])
            ;
        }

        public function test_returns_empty_when_no_matching_comfort_categories(): void
        {
            $this->employee->positions()->detach();

            $response = $this->actingAs($this->employee->user)
                ->json('GET', '/api/v1/available-cars', [
                    'start_time' => now()->addHour()->toDateTimeString(),
                    'end_time'   => now()->addHours(2)->toDateTimeString(),
                ])
            ;

            $response->assertJsonCount(0);
        }

        /**
         * @noinspection PhpPossiblePolymorphicInvocationInspection
         */
        public function test_validates_time_parameters(): void
        {
            $response = $this->actingAs($this->employee->user)
                ->json('GET', '/api/v1/available-cars', [
                    'start_time' => 'invalid-date',
                    'end_time'   => now()->addHour()->toDateTimeString(),
                ])
            ;

            $response->assertStatus(422)
                ->assertJsonValidationErrors([ 'start_time' ])
            ;
        }

        /**
         * @noinspection PhpPossiblePolymorphicInvocationInspection
         */
        public function test_handles_edge_time_conditions(): void
        {
            $car = Car::factory()->create([ 'car_model_id' => $this->carModel->id ]);

            CarReservation::factory()->create([
                'car_id'     => $car->id,
                'start_time' => now()->addHour(),
                'end_time'   => now()->addHours(2),
            ]);

            $response = $this->actingAs($this->employee->user)
                ->json('GET', '/api/v1/available-cars', [
                    'start_time' => now()->addHours(2)->toDateTimeString(),
                    'end_time'   => now()->addHours(3)->toDateTimeString(),
                ])
            ;

            $response->assertJsonCount(1);
        }

        /** @noinspection PhpPossiblePolymorphicInvocationInspection */
        protected function setUp(): void
        {
            parent::setUp();

            $this->comfortCategory = ComfortCategory::factory()->create([
                'comfort_category_name' => 'Premium',
            ]);

            $position = Position::factory()->create();
            $position->comfortCategories()->attach($this->comfortCategory);

            $user = User::factory()->create();
            $this->employee = Employee::factory()->create([ 'user_id' => $user->id ]);
            $this->employee->positions()->attach($position);

            $this->carModel = CarModel::factory()->create([
                'comfort_category_id' => $this->comfortCategory->id,
                'model_name'          => 'Tesla Model S',
            ]);
        }

    }
