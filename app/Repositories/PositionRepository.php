<?php

    namespace App\Repositories;


    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Collection;
    use App\Interfaces\PositionRepositoryInterface;
    use Illuminate\Contracts\Pagination\LengthAwarePaginator;

    class PositionRepository implements PositionRepositoryInterface
    {

        public function forEmployeesTable($employeeIds): Collection
        {
            return DB::table('positions')
                ->leftJoin('employee_position', 'positions.id', '=', 'employee_position.position_id')
                ->whereIn('employee_id', $employeeIds)
                ->get()
            ;
        }

        public function forPositionsTable($sortBy, $sortDirection, $perPage, $columns = [ '*' ]): LengthAwarePaginator
        {
            $query = DB::table('positions')
                ->select($columns)
            ;

            $sortBy = (array) $sortBy;
            foreach ($sortBy as $field) {
                $query->orderBy($field);
            }

            return $query->paginate($perPage);
        }

    }
