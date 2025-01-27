<?php

    namespace App\Livewire\Reservation;


    use App\Models\User;
    use Livewire\Component;
    use App\Models\Employee;
    use Illuminate\Support\Carbon;
    use App\Models\CarReservation;
    use Livewire\Attributes\Validate;
    use Illuminate\Contracts\View\View;
    use Illuminate\Support\Facades\Auth;
    use App\Interfaces\CarServiceInterface;
    use Illuminate\Database\Eloquent\Collection;
    use App\Interfaces\CarModelRepositoryInterface;
    use App\Interfaces\ComfortCategoryRepositoryInterface;

    class CarSearch extends Component
    {

        #[Validate]
        public $startTime;

        #[Validate]
        public $endTime;

        #[Validate]
        public ?int $selectedModel = NULL;

        #[Validate]
        public ?int $selectedCategory = NULL;

        public $models = [];

        public $categories = [];

        public $availableCars = [];

        public $timezone;

        public $employeeId;

        public function mount(
            CarModelRepositoryInterface $carModelRepository,
            ComfortCategoryRepositoryInterface $comfortCategoryRepository,
        ): void {
            /** @var User $user */
            $user = Auth::user();

            $this->timezone = $user->safeTimezone();
            $this->employeeId = Employee::query()->where('user_id', $user->id)->first()?->id;

            $this->models = $carModelRepository->all([ 'id', 'model_name' ]);
            $this->categories = $comfortCategoryRepository->all([ 'id', 'comfort_category_name' ]);
        }

        public function searchAvailableCars(
            CarServiceInterface $carService,
        ): void {
            if (! $this->employeeId) {
                $this->addError('custom_error', __('Вы не являетесь сотрудником компании.'));

                return;
            }

            $this->validate();

            $startTime = $this->convertToAppTimezone($this->startTime);
            $endTime = $this->convertToAppTimezone($this->endTime);

            $availableCars = $carService->getAvailableCars(
                $this->employeeId,
                $startTime,
                $endTime,
                $this->selectedModel,
                $this->selectedCategory,
            );
            /** @var Collection $availableCars */
            $availableCars->load('carModel.comfortCategory', 'driver');

            $this->availableCars = $availableCars;
        }

        protected function convertToAppTimezone($dateTime)
        {
            return Carbon::parse($dateTime, $this->timezone)
                ->setTimezone(config('app.timezone'))
            ;
        }

        public function reserve(
            $carId,
            CarServiceInterface $carService,
        ) {
            if (! $this->employeeId) {
                $this->addError('custom_error', 'Вы не являетесь сотрудником компании');

                return;
            }

            $startTime = $this->convertToAppTimezone($this->startTime);
            $endTime = $this->convertToAppTimezone($this->endTime);

            if ($carService->isCarAvailable($carId, $startTime, $endTime)) {
                /** @var CarReservation $carReservation */
                $carReservation = CarReservation::create([
                    'car_id'      => $carId,
                    'employee_id' => $this->employeeId,
                    'start_time'  => $startTime,
                    'end_time'    => $endTime,
                ]);

                if ($carReservation) {
                    $this->addError("successful_reserved_$carId", __('Зарезервировано'));
                } else {
                    $this->addError("already_reserved_$carId", __('Что-то пошло не так.'));
                }
            } else {
                $this->addError("already_reserved_$carId",
                    __('Другой сотрудник успел забронировать автомобиль раньше вас.'));
            }
        }

        public function render(): View
        {
            return view('components.reservation.car-search', [
                'availableCars' => $this->availableCars,
                'models'        => $this->models,
                'categories'    => $this->categories,
            ]);
        }

        public function getRules(): array
        {
            return [
                'startTime'        => 'required|after:now',
                'endTime'          => 'required|after:now|after:startTime',
                'selectedCategory' => 'nullable|exists:App\Models\ComfortCategory,id',
                'selectedModel'    => 'nullable|exists:App\Models\CarModel,id',
            ];
        }

        public function messages(): array
        {
            return [
                'startTime.required'     => __('Поле дата начала должно быть заполнено.'),
                'endTime.required'       => __('Поле дата окончания должно быть заполнено.'),
                'startTime.after:now'     => __('Дата окончания должна указывать на будущее время.'),
                'endTime.after:now'       => __('Дата начала должна указывать на будущее время.'),
                'endTime.after:startTime' => __('Дата окончания должна быть позже даты начала.'),
                'selectedCategory'        => __('Выбрана несуществующая категория.'),
                'selectedModel'           => __('Выбрана несуществующая модель.'),
            ];
        }

        protected function prepareForValidation($attributes)
        {
            if ($this->startTime) {
                $attributes = array_merge($attributes, [
                    'startTime' => $this->convertToAppTimezone($this->startTime),
                ]);
            }
            if ($this->endTime) {
                $attributes = array_merge($attributes, [
                    'endTime' => $this->convertToAppTimezone($this->endTime),
                ]);
            }

            return $attributes;
        }

    }
