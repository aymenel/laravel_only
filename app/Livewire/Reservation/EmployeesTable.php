<?php

    namespace App\Livewire\Reservation;


    use App\Models\User;
    use Livewire\Component;
    use Illuminate\View\View;
    use Illuminate\Support\Arr;
    use Livewire\WithPagination;
    use Illuminate\Support\Facades\Auth;
    use App\Interfaces\EmployeeRepositoryInterface;
    use App\Interfaces\PositionRepositoryInterface;

    class EmployeesTable extends Component
    {

        use WithPagination;

        public string $sortBy = 'id';

        public string $sortDirection = 'asc';

        public int $perPage = 10;

        protected $updatesQueryString = [ 'sortBy', 'sortDirection' ];

        protected $queryString = [
            'sortBy'        => [ 'except' => 'created_at' ],
            'sortDirection' => [ 'except' => 'desc' ],
            'perPage'       => [ 'except' => 10 ],
        ];

        public function sortByField(string $field): void
        {
            if ($this->sortBy === $field) {
                $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
            } else {
                $this->sortBy = $field;
                $this->sortDirection = 'asc';
            }

            $this->resetPage();
        }

        public function render(
            EmployeeRepositoryInterface $employeeRepository,
            PositionRepositoryInterface $positionRepository
        ): View
        {
            $employees = $employeeRepository
                ->forEmployeesTable($this->sortBy, $this->sortDirection, $this->perPage, ['employees.*', 'users.*'])
            ;

            $ids = Arr::pluck($employees->items(), 'id');
            $positions = $positionRepository->forEmployeesTable($ids);

            $employees->through(function ($employee) use ($positions) {
                $positions = $positions
                    ->where('employee_id', $employee->id)
                    ->pluck('position_name')
                ;

                $employee->positions_names = $positions;

                return $employee;
            });

            return view('components.reservation.employees-table', [
                'employees' => $employees,
            ]);
        }

        public function authAs(string $email)
        {
            /** @var User $user */
            $user = User::query()->where('email', $email)->firstOrFail();

            Auth::login($user);

            $this->redirect(request()?->header('Referer'), navigate: true);
        }

    }
