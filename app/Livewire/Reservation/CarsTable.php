<?php

    namespace App\Livewire\Reservation;


    use Livewire\Component;
    use Illuminate\View\View;
    use Livewire\WithPagination;
    use App\Interfaces\CarRepositoryInterface;

    class CarsTable extends Component
    {

        use WithPagination;

        public string $sortBy = 'id';

        public string $sortDirection = 'desc';

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
            CarRepositoryInterface $carRepository
        ): View
        {
            if ($this->sortBy === 'driver.fullName') {
                $sortBy = [ 'employees.surname', 'employees.name', 'employees.patronymic', ];
            } else {
                $sortBy = (array) $this->sortBy;
            }

            $cars = $carRepository->forCarTable(
                $sortBy,
                $this->sortDirection,
                $this->perPage,
                [ 'cars.*', 'employees.*', 'car_models.*', 'comfort_categories.*']
            );

            return view('components.reservation.cars-table', [
                'cars' => $cars,
            ]);
        }

    }
