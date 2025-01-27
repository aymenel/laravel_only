<div>
    <table class="min-w-full text-left text-sm font-light text-surface dark:text-white">
        <thead class="border-b border-neutral-200 font-medium dark:border-white/10">
        <tr>
            <th scope="col" class="px-6 py-4 tracking-wider cursor-pointer" wire:click="sortByField('id')">
                {{ __('Id') }}
                @if ($sortBy == 'id')
                    @if ($sortDirection == 'asc')
                        <i class="fas fa-sort-alpha-up ml-1"></i>
                    @else
                        <i class="fas fa-sort-alpha-down ml-1"></i>
                    @endif
                @else
                    <i class="fas fa-sort ml-1"></i>
                @endif
            </th>
            <th scope="col" class="px-6 py-4 tracking-wider cursor-pointer" wire:click="sortByField('surname')">
                {{ __('Фамилия') }}
                @if ($sortBy == 'surname')
                    @if ($sortDirection == 'asc')
                        <i class="fas fa-sort-alpha-up ml-1"></i>
                    @else
                        <i class="fas fa-sort-alpha-down ml-1"></i>
                    @endif
                @else
                    <i class="fas fa-sort ml-1"></i>
                @endif
            </th>
            <th scope="col" class="px-6 py-4 tracking-wider cursor-pointer" wire:click="sortByField('name')">
                {{ __('Имя') }}
                @if ($sortBy == 'name')
                    @if ($sortDirection == 'asc')
                        <i class="fas fa-sort-alpha-up ml-1"></i>
                    @else
                        <i class="fas fa-sort-alpha-down ml-1"></i>
                    @endif
                @else
                    <i class="fas fa-sort ml-1"></i>
                @endif
            </th>
            <th scope="col" class="px-6 py-4 tracking-wider cursor-pointer" wire:click="sortByField('patronymic')">
                {{ __('Отчество') }}
                @if ($sortBy == 'patronymic')
                    @if ($sortDirection == 'asc')
                        <i class="fas fa-sort-alpha-up ml-1"></i>
                    @else
                        <i class="fas fa-sort-alpha-down ml-1"></i>
                    @endif
                @else
                    <i class="fas fa-sort ml-1"></i>
                @endif
            </th>
            <th scope="col" class="px-6 py-4 tracking-wider">
                {{ __('Должности') }}
            </th>
            <th scope="col" class="px-6 py-4 tracking-wider">
                {{ __('Почта') }}
            </th>
        </tr>
        </thead>
        <tbody>
        @forelse($employees as $employee)
            <tr class="border-b border-neutral-200 dark:border-white/10">
                <td class="whitespace-nowrap px-6 py-4">
                    {{ $employee->id }}
                </td>
                <td class="whitespace-nowrap px-6 py-4">
                    {{ $employee->surname }}
                </td>
                <td class="whitespace-nowrap px-6 py-4">
                    {{ $employee->name }}
                </td>
                <td class="whitespace-nowrap px-6 py-4">
                    {{ $employee->patronymic }}
                </td>
                <td class="whitespace-nowrap px-6 py-4">
                    {!! $employee->positions_names->implode('<br>') !!}
                </td>
                <td class="whitespace-nowrap px-6 py-4">
                    <a href="javascript:" class="underline" wire:click="authAs('{{ $employee->email }}')">{{ $employee->email }}</a>
                </td>
            </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-4 py-2 text-center">{{ __('Нет данных') }}</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div class="flex justify-between p-4">
        {{ $employees->links(data: ['tailwindcss' => TRUE]) }}
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
