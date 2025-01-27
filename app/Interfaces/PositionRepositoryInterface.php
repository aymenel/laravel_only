<?php

    namespace App\Interfaces;


    use Illuminate\Support\Collection;
    use Illuminate\Contracts\Pagination\LengthAwarePaginator;

    interface PositionRepositoryInterface
    {

        public function forEmployeesTable($employeeIds): Collection;

        public function forPositionsTable($sortBy, $sortDirection, $perPage, $columns = [ '*' ]): LengthAwarePaginator;

    }
