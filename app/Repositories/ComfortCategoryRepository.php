<?php

    namespace App\Repositories;


    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Collection;
    use App\Interfaces\ComfortCategoryRepositoryInterface;
    use Illuminate\Contracts\Pagination\LengthAwarePaginator;

    class ComfortCategoryRepository implements ComfortCategoryRepositoryInterface
    {

        /**
         * @param array|string $columns
         * @return Collection
         */
        public function all($columns = [ '*' ]): Collection
        {
            return DB::table('comfort_categories')->get($columns);
        }

        public function forPositionsTable($positionIds): Collection
        {
            return DB::table('comfort_categories')
                ->leftJoin('comfort_category_position', 'comfort_categories.id', '=', 'comfort_category_position.comfort_category_id')
                ->whereIn('position_id', $positionIds)
                ->get()
            ;
        }

        public function forComfortCategoryTable($sortBy, $sortDirection, $perPage, $columns = [ '*' ]): LengthAwarePaginator
        {
            $query = DB::table('comfort_categories')->select($columns);

            $sortBy = (array) $sortBy;
            foreach ($sortBy as $field) {
                $query->orderBy($field);
            }

            return $query->paginate($perPage);
        }

    }
