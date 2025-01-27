<?php

    namespace App\Interfaces;


    use Illuminate\Support\Collection;
    use Illuminate\Contracts\Pagination\LengthAwarePaginator;

    interface ComfortCategoryRepositoryInterface
    {

        /**
         * @param array|string $columns
         * @return Collection
         */
        public function all($columns = [ '*' ]): Collection;

        public function forPositionsTable($positionIds): Collection;

        public function forComfortCategoryTable($sortBy, $sortDirection, $perPage, $columns = [ '*' ]): LengthAwarePaginator;

    }
