<div>
    <table class="min-w-full text-left text-sm font-light text-surface dark:text-white">
        <thead class="border-b border-neutral-200 font-medium dark:border-white/10">
        <tr>
            <th scope="col" class="px-6 py-4 tracking-wider cursor-pointer" wire:click="sortByField('cars.id')">
                {{ __('Id') }}
                @if ($sortBy == 'cars.id')
                    @if ($sortDirection == 'asc')
                        <i class="fas fa-sort-alpha-up ml-1"></i>
                    @else
                        <i class="fas fa-sort-alpha-down ml-1"></i>
                    @endif
                @else
                    <i class="fas fa-sort ml-1"></i>
                @endif
            </th>
            <th scope="col" class="px-6 py-4 tracking-wider cursor-pointer" wire:click="sortByField('cars.number')">
                {{ __('Номер') }}
                @if ($sortBy == 'cars.number')
                    @if ($sortDirection == 'asc')
                        <i class="fas fa-sort-alpha-up ml-1"></i>
                    @else
                        <i class="fas fa-sort-alpha-down ml-1"></i>
                    @endif
                @else
                    <i class="fas fa-sort ml-1"></i>
                @endif
            </th>
            <th scope="col" class="px-6 py-4 tracking-wider cursor-pointer" wire:click="sortByField('car_models.model_name')">
                {{ __('Модель') }}
                @if ($sortBy == 'car_models.model_name')
                    @if ($sortDirection == 'asc')
                        <i class="fas fa-sort-alpha-up ml-1"></i>
                    @else
                        <i class="fas fa-sort-alpha-down ml-1"></i>
                    @endif
                @else
                    <i class="fas fa-sort ml-1"></i>
                @endif
            </th>
            <th scope="col" class="px-6 py-4 tracking-wider cursor-pointer" wire:click="sortByField('comfort_categories.comfort_category_name')">
                {{ __('Категория комфорта') }}
                @if ($sortBy == 'comfort_categories.comfort_category_name')
                    @if ($sortDirection == 'asc')
                        <i class="fas fa-sort-alpha-up ml-1"></i>
                    @else
                        <i class="fas fa-sort-alpha-down ml-1"></i>
                    @endif
                @else
                    <i class="fas fa-sort ml-1"></i>
                @endif
            </th>
            <th scope="col" class="px-6 py-4 tracking-wider cursor-pointer" wire:click="sortByField('driver.fullName')">
                {{ __('Водитель') }}
                @if ($sortBy == 'driver.fullName')
                    @if ($sortDirection == 'asc')
                        <i class="fas fa-sort-alpha-up ml-1"></i>
                    @else
                        <i class="fas fa-sort-alpha-down ml-1"></i>
                    @endif
                @else
                    <i class="fas fa-sort ml-1"></i>
                @endif
            </th>
        </tr>
        </thead>
        <tbody>
        @forelse($cars as $car)
            <tr class="border-b border-neutral-200 dark:border-white/10">
                <td class="whitespace-nowrap px-6 py-4">
                    {{ $car->id }}
                </td>
                <td class="whitespace-nowrap px-6 py-4">
                    {{ $car->number }}
                </td>
                <td class="whitespace-nowrap px-6 py-4">
                    {{ $car->model_name }}
                </td>
                <td class="whitespace-nowrap px-6 py-4">
                    {{ $car->comfort_category_name }}
                </td>
                <td class="whitespace-nowrap px-6 py-4">
                    {{ $car->surname }} {{ $car->name }} {{ $car->patronymic }}
                </td>
            </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-4 py-2 text-center">{{ __('Нет данных') }}</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div class="flex justify-between p-4">
        {{ $cars->links(data: ['tailwindcss' => TRUE]) }}
        <div class="flex items-center justify-end">
            <label for="perPage" class="block flex-auto font-bold me-2 text-gray-700 text-sm">{{ __('Строк') }}:</label>
            <select
                id="perPage" class="appearance-none border flex-auto focus:outline-none focus:shadow-outline leading-tight py-2 rounded shadow text-gray-700 w-full"
                wire:model.live="perPage"
            >
                <option>5</option>
                <option>10</option>
                <option>15</option>
                <option>25</option>
            </select>
        </div>
    </div>
</div>
