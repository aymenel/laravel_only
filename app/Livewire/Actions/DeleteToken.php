<?php

    namespace App\Livewire\Actions;


    use App\Models\User;
    use Illuminate\Support\Facades\Auth;

    class DeleteToken
    {

        public function __invoke(): void
        {
            /** @var User $user */
            $user = Auth::user();
            $user->tokens()->whereName('api_token')->delete();
        }

    }
