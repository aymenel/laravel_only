<?php

    namespace App\Livewire\Reservation;


    use Livewire\Component;
    use Illuminate\View\View;
    use Livewire\WithPagination;
    use App\Models\ComfortCategory;
    use App\Interfaces\ComfortCategoryRepositoryInterface;

    class ComfortCategoriesTable extends Component
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
            ComfortCategoryRepositoryInterface $comfortCategoryRepository
        ): View
        {
            $comfort_categories = $comfortCategoryRepository->forComfortCategoryTable(
                $this->sortBy,
                $this->sortDirection,
                $this->perPage
            );

            return view('components.reservation.comfort-categories-table', [
                'comfort_categories' => $comfort_categories,
            ]);
        }

    }
