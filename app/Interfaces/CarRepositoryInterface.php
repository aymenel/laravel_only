<?php

    namespace App\Interfaces;


    use Illuminate\Contracts\Pagination\LengthAwarePaginator;

    interface CarRepositoryInterface
    {

        public function forCarTable($sortBy, $sortDirection, $perPage, $columns = [ '*' ]): LengthAwarePaginator;

    }
