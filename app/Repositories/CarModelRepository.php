<?php

    namespace App\Repositories;


    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Collection;
    use App\Interfaces\CarModelRepositoryInterface;

    class CarModelRepository implements CarModelRepositoryInterface
    {

        /**
         * @param array|string $columns
         * @return Collection
         */
        public function all($columns = [ '*' ]): Collection
        {
            return DB::table('car_models')->get($columns);
        }

    }
