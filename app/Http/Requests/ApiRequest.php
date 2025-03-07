<?php

    namespace App\Http\Requests;


    use Illuminate\Foundation\Http\FormRequest;
    use Illuminate\Contracts\Validation\Validator;
    use Illuminate\Http\Exceptions\HttpResponseException;

    class ApiRequest extends FormRequest
    {

        protected function failedValidation(Validator $validator)
        {
            throw new HttpResponseException(
                response()->json([
                    'success' => FALSE,
                    'message' => 'Validation errors',
                    'errors'  => $validator->errors(),
                ], 422),
            );
        }

    }
