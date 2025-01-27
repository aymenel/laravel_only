<?php

    namespace App\Interfaces;


    use App\Models\Employee;
    use Illuminate\Support\Carbon;
    use Illuminate\Database\Eloquent\Collection;

    interface CarServiceInterface
    {

        public function getAvailableCars(
            Employee|string $employee,
            Carbon $startTime,
            Carbon $endTime,
            ?int $carModelId = NULL,
            ?int $comfortCategoryId = NULL,
        ): Collection;

        public function isCarAvailable($carId, Carbon $startTime, Carbon $endTime): bool;

    }
