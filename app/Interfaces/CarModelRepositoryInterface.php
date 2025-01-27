<?php

    namespace App\Interfaces;


    use Illuminate\Support\Collection;

    interface CarModelRepositoryInterface
    {

        /**
         * @param array|string $columns
         * @return Collection
         */
        public function all($columns = [ '*' ]): Collection;

    }
