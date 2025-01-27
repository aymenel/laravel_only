<div>
    <form wire:submit="searchAvailableCars">
        <div>
            <label>{{ __('Начало бронирования') }}:</label>
            <input
                type="datetime-local"
                class="text-black"
                wire:model.blur="startTime"
                min="{{ now()->format('Y-m-d\TH:i') }}"
            >
            @error('startTime')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label>{{ __('Окончание бронирования') }}:</label>
            <input
                type="datetime-local"
                class="text-black"
                wire:model.blur="endTime"
                min="{{ $startTime }}"
            >
            @error('endTime')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label>{{ __('Модель автомобиля') }}:</label>
            <select
                class="text-black"
                wire:model.blur="selectedModel"
            >
                <option class="text-black" value="">{{ __('Любая модель') }}</option>
                @foreach($models as $model)
                    <option class="text-black" value="{{ $model->id }}">{{ $model->model_name }}</option>
                @endforeach
            </select>
            @error('selectedModel')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label>{{ __('Категория комфорта') }}:</label>
            <select
                class="text-black"
                wire:model.blur="selectedCategory"
            >
                <option class="text-black" value="">{{ __('Любая категория') }}</option>
                @foreach($categories as $category)
                    <option class="text-black" value="{{ $category->id }}">
                        {{ $category->comfort_category_name }}
                    </option>
                @endforeach
            </select>
            @error('selectedCategory')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <x-primary-button type="submit">{{ __('Найти') }}</x-primary-button>
    </form>

    <div>
        <h3>{{ __('Свободные автомобили') }}:</h3>

        @if ($errors->has('custom_error'))
            @foreach($errors->get('custom_error') as $message)
                <span class="error text-red-700">{{ $message }}</span>
            @endforeach
        @else
            @forelse($availableCars as $car)
                <div class="mb-4 border-b-2">
                    <h4 class="text-2xl">#{{ $car->id }} {{ $car->carModel->model_name }}</h4>
                    <p>{{ __('Номер') }}: {{ $car->number }}</p>
                    <p>{{ __('Категория комфорта') }}: {{ $car->carModel->comfortCategory->comfort_category_name }}</p>
                    <p>{{ __('Водитель') }}: {{ $car->driver->fullName }}</p>

                    @if ($errors->has("already_reserved_{$car->id}"))
                        @foreach($errors->get("already_reserved_{$car->id}") as $message)
                            <span class="error text-red-700 mb-4">{{ $message }}</span>
                        @endforeach
                    @elseif ($errors->has("successful_reserved_{$car->id}"))
                        @foreach($errors->get("successful_reserved_{$car->id}") as $message)
                            <span class="error text-green-500 mb-4">{{ $message }}</span>
                        @endforeach
                    @else
                        <x-primary-button class="mb-4" wire:click="reserve('{{ $car->id }}')">
                            {{ __('Забронировать') }}
                        </x-primary-button>
                    @endif
                </div>
            @empty
                <p>{{ __('Нет свободных автомобилей') }}</p>
            @endforelse
        @endif
    </div>
</div>
