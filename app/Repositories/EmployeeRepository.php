<?php

    namespace App\Repositories;


    use Illuminate\Support\Facades\DB;
    use App\Interfaces\EmployeeRepositoryInterface;
    use Illuminate\Contracts\Pagination\LengthAwarePaginator;

    class EmployeeRepository implements EmployeeRepositoryInterface
    {

        /**
         * @param array|string $columns
         * @return LengthAwarePaginator
         */
        public function forEmployeesTable($sortBy, $sortDirection, $perPage, $columns = [ '*' ]): LengthAwarePaginator
        {
            $query = DB::table('employees')
                ->select($columns)
                ->leftJoin('users', 'employees.user_id', '=', 'users.id')
                ->orderBy($sortBy, $sortDirection)
            ;

            $sortBy = (array) $sortBy;
            foreach ($sortBy as $field) {
                $query->orderBy($field);
            }

            return $query->paginate($perPage);
        }

    }
