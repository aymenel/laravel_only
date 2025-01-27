<?php

    namespace App\Services;


    use App\Models\Car;
    use App\Models\Employee;
    use Illuminate\Support\Carbon;
    use App\Models\CarReservation;
    use App\Interfaces\CarServiceInterface;
    use Illuminate\Database\Eloquent\Collection;

    class CarService implements CarServiceInterface
    {

        public function getAvailableCars(
            Employee|string $employee,
            Carbon $startTime,
            Carbon $endTime,
            ?int $carModelId = NULL,
            ?int $comfortCategoryId = NULL,
        ): Collection {
            if (is_string($employee)) {
                $employee = Employee::find($employee);
            }

            $allowedComfortCategoryIds = $employee->positions()
                ->join('comfort_category_position', 'positions.id', '=', 'comfort_category_position.position_id')
                ->pluck('comfort_category_position.comfort_category_id')
            ;

            $query = Car::query();

            $query->whereHas('carModel', function($q) use ($allowedComfortCategoryIds) {
                $q->whereIn('comfort_category_id', $allowedComfortCategoryIds);
            });

            if ($carModelId) {
                $query->where('car_model_id', $carModelId);
            }

            if ($comfortCategoryId) {
                $query->whereHas('carModel', function($q) use ($comfortCategoryId) {
                    $q->where('comfort_category_id', $comfortCategoryId);
                });
            }

            $reservedCarIds = $this->getReservedCarsQuery(CarReservation::query(), $startTime, $endTime)->pluck('car_id');

            $query->whereNotIn('id', $reservedCarIds);

            return $query->get();
        }

        public function isCarAvailable($carId, Carbon $startTime, Carbon $endTime): bool
        {
            $query = CarReservation::query()->where('id', $carId);
            $reservedCarIds = $this->getReservedCarsQuery($query, $startTime, $endTime)->count();

            return ($reservedCarIds === 0);
        }

        protected function getReservedCarsQuery($query, Carbon $startTime, Carbon $endTime)
        {
            // Что бы не исключать из выборки автомобили, которые хотят арендовать во время окончания предыдущей аренды
            /** @noinspection CallableParameterUseCaseInTypeContextInspection */
            $startTime = $startTime->copy()->addSeconds(1);
            /** @noinspection CallableParameterUseCaseInTypeContextInspection */
            $endTime = $endTime->copy()->addSeconds(-1);

            return $query
                ->where(function($q) use ($startTime, $endTime) {
                    $q->whereBetween('start_time', [$startTime, $endTime])
                        ->orWhereBetween('end_time', [$startTime, $endTime])
                        ->orWhere(function($q) use ($startTime, $endTime) {
                            $q->where('start_time', '<=', $startTime)
                                ->where('end_time', '>=', $endTime);
                        })
                    ;
                })
            ;
        }

    }
