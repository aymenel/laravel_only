<?php

    namespace App\Http\Controllers;


    use App\Models\User;
    use App\Models\Employee;
    use Illuminate\Support\Arr;
    use App\Models\CarReservation;
    use Illuminate\Support\Carbon;
    use Illuminate\Contracts\View\View;
    use Illuminate\Support\Facades\Auth;
    use App\Interfaces\CarServiceInterface;
    use App\Http\Requests\CheckCarsReservationsRequest;

    class CarController extends Controller
    {

        public function indexCars(): View
        {
            return view('reservation.cars');
        }

        public function indexCarReservations(): View
        {
            /** @var $carReservations */
            $carReservations = CarReservation::with([ 'car.carModel', 'car.driver', 'employee.positions' ])
                ->get()->all()
            ;

            $timezone = Auth::user()?->safeTimezone();
            $carReservations = Arr::map($carReservations, static function(CarReservation $item) use ($timezone) {
                $item->start_time = $item->start_time->setTimezone($timezone);
                $item->end_time = $item->end_time->setTimezone($timezone);

                return $item;
            });

            return view('reservation.car_reservations', [
                'car_reservations' => $carReservations,
            ]);
        }

        public function getAvailableCars(
            CheckCarsReservationsRequest $request,
            CarServiceInterface $carService
        )
        {
            /** @var User $user */
            $user = Auth::user();

            $this->timezone = $user->safeTimezone();
            $employee = Employee::query()->where('user_id', $user->id)->first();

            if (! $employee) {
                return response()->json([
                    'success' => FALSE,
                    'message' => __('Текущий пользователь не занимает должности в компании'),
                ]);
            }

            $startTime = $request->validated('start_time');
            $startTime = Carbon::parse($startTime, $this->timezone)
                ->setTimezone(config('app.timezone'));

            $endTime = $request->validated('end_time');
            $endTime = Carbon::parse($endTime, $this->timezone)
                ->setTimezone(config('app.timezone'));

            $result = $carService->getAvailableCars(
                $employee,
                $startTime,
                $endTime,
                $request->validated('car_model_id'),
                $request->validated('comfort_category_id'),
            );

            return response($result);
        }

        public function indexCarSearch(): View
        {
            return view('reservation.car_search');
        }

    }
