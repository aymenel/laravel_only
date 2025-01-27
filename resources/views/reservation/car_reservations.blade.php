<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Зарезервированные автомобили') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <table class="min-w-full text-left text-sm font-light text-surface dark:text-white">
                        <thead class="border-b border-neutral-200 font-medium dark:border-white/10">
                            <tr>
                                <th scope="col" class="px-6 py-4">
                                    {{ __('Id') }}
                                </th>
                                <th scope="col" class="px-6 py-4">
                                    {{ __('Автомобиль') }}
                                </th>
                                <th scope="col" class="px-6 py-4">
                                    {{ __('Сотрудник') }}
                                </th>
                                <th scope="col" class="px-6 py-4">
                                    {{ __('Начало') }}
                                </th>
                                <th scope="col" class="px-6 py-4">
                                    {{ __('Окончание') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse($car_reservations as $car_reservation)
                            <tr class="border-b border-neutral-200 dark:border-white/10">
                                <td class="whitespace-nowrap px-6 py-4">
                                    {{ $car_reservation->id }}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    Модель: {{ $car_reservation->car->carModel->model_name }}<br>
                                    Номер: {{ $car_reservation->car->number }}<br>
                                    Водитель: {{ $car_reservation->car->driver?->fullName ?? '-' }}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    {{ $car_reservation->employee->positions->pluck('position_name')->join(', ') }}<br>
                                    {{ $car_reservation->employee->fullName }}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    {{ $car_reservation->start_time->format('d.m.Y') }}<br>
                                    {{ $car_reservation->start_time->format('H:nn:s') }}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    {{ $car_reservation->end_time->format('d.m.Y') }}<br>
                                    {{ $car_reservation->end_time->format('H:nn:s') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-2 text-center">{{ __('Нет данных') }}</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
