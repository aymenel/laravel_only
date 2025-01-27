<?php

    namespace App\Livewire\Reservation;


    use Livewire\Component;
    use Illuminate\View\View;
    use Illuminate\Support\Arr;
    use Livewire\WithPagination;
    use App\Interfaces\PositionRepositoryInterface;
    use App\Interfaces\ComfortCategoryRepositoryInterface;

    class PositionsTable extends Component
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
            PositionRepositoryInterface $positionRepository,
            ComfortCategoryRepositoryInterface $comfortCategoryRepository,
        ): View {
            $positions = $positionRepository
                ->forPositionsTable($this->sortBy, $this->sortDirection, $this->perPage, 'positions.*')
            ;

            $ids = Arr::pluck($positions->items(), 'id');
            $comfortCategories = $comfortCategoryRepository->forPositionsTable($ids);

            $positions->through(function($position) use ($comfortCategories) {
                $comfortCategoriesNames = $comfortCategories
                    ->where('position_id', $position->id)
                    ->pluck('comfort_category_name')
                ;

                $position->comfort_categories = $comfortCategoriesNames;

                return $position;
            });

            return view('components.reservation.positions-table', [
                'positions' => $positions,
            ]);
        }

    }
