<?php

    namespace App\Interfaces;


    use Illuminate\Contracts\Pagination\LengthAwarePaginator;

    interface EmployeeRepositoryInterface
    {

        public function forEmployeesTable($sortBy, $sortDirection, $perPage, $columns = [ '*' ]): LengthAwarePaginator;

    }
