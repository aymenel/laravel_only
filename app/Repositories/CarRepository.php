<?php

    namespace App\Repositories;


    use Illuminate\Support\Facades\DB;
    use App\Interfaces\CarRepositoryInterface;
    use Illuminate\Contracts\Pagination\LengthAwarePaginator;

    class CarRepository implements CarRepositoryInterface
    {

        public function forCarTable($sortBy, $sortDirection, $perPage, $columns = [ '*' ]): LengthAwarePaginator
        {
            $query = DB::table('cars')
                ->select($columns)
                ->leftJoin('employees', 'cars.driver_id', '=', 'employees.id')
                ->leftJoin('car_models', 'cars.car_model_id', '=', 'car_models.id')
                ->leftJoin('comfort_categories', 'car_models.comfort_category_id', '=', 'comfort_categories.id')
            ;

            $sortBy = (array) $sortBy;
            foreach ($sortBy as $field) {
                $query->orderBy($field);
            }

            return $query->paginate($perPage);
        }

    }
