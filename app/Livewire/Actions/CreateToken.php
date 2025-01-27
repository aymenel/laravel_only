<?php

    namespace App\Livewire\Actions;


    use App\Models\User;
    use Illuminate\Support\Str;
    use Illuminate\Support\Facades\Auth;

    class CreateToken
    {

        public function __invoke(): string
        {
            /** @var User $user */
            $user = Auth::user();

            $user->tokens()->whereName('api_token')->delete();

            $token = $user->createToken('api_token')->plainTextToken;

            return Str::after($token, '|');
        }

    }
