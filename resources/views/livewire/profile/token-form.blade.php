<?php


    use Illuminate\Support\Facades\Auth;
    use Livewire\Volt\Component;
    use App\Livewire\Actions\CreateToken;
    use App\Livewire\Actions\DeleteToken;

    new class extends Component {

        public ?string $token;

        public function mount()
        {
            $this->token = Auth::user()?->tokens()->whereName('api_token')->first()?->token;
        }

        public function createToken(CreateToken $createToken): void
        {
            $this->token = $createToken();

            $this->dispatch('open-modal', 'generated-token');
        }

        public function deleteToken(DeleteToken $deleteToken): void
        {
            $deleteToken();
            $this->token = '';

            $this->dispatch('close-modal', 'confirm-token-deletion');
        }

    };
?>

<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Токен') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ $token ? __('Ваш токен') . ': ********************' : '' }}
        </p>
    </header>

    <x-primary-button
        x-data=""
        wire:click="createToken"
    >{{ $token ? __('Обновить токен') : __('Создать токен') }}</x-primary-button>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-token-deletion')"
        class="ms-3"
    >{{ __('Удалить токен') }}</x-danger-button>

    <x-modal
        name="confirm-token-deletion"
        :show="$errors->isNotEmpty()"
        focusable
    >
        <form wire:submit="deleteToken" class="p-6">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Удалить токен') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('Любые приложения или сценарии с использованием этого токена больше не смогут получить доступ к API. Вы не можете отменить это действие.') }}
            </p>

            <div class="mt-6 flex justify-end">
                <x-primary-button x-on:click="$dispatch('close')">
                    {{ __('Отмена') }}
                </x-primary-button>

                <x-danger-button class="ms-3">
                    {{ __('Я понимаю, удалите этот токен') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>

    <x-modal
        name="generated-token"
        focusable
    >
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Токен') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('Ваш токен') }}: <code class="text-red-600">{{ $token }}</code><br><br>
                {{ __('Обязательно скопируйте свой личный токен доступа, так как вы не сможете увидеть его снова.') }}
            </p>

            <div class="mt-6 flex justify-end">
                <x-primary-button x-on:click="$dispatch('close')">
                    {{ __('Закрыть') }}
                </x-primary-button>
            </div>
        </div>
    </x-modal>
</section>
