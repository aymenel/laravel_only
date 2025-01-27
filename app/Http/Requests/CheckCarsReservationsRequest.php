<?php

    namespace App\Http\Requests;


    use DateTime;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Contracts\Validation\ValidationRule;

    /**
     * @property DateTime    start_time
     * @property DateTime    end_time
     * @property string|null comfort_category_id
     * @property string|null car_model_id
     */
    class CheckCarsReservationsRequest extends ApiRequest
    {

        /**
         * Determine if the user is authorized to make this request.
         */
        public function authorize(): bool
        {
            return Auth::check();
        }

        /**
         * Get the validation rules that apply to the request.
         * @return array<string, ValidationRule|array<mixed>|string>
         */
        public function rules(): array
        {
            return [
                'start_time'          => 'required|date_format:Y-m-d H:i:s',
                'end_time'            => 'required|date_format:Y-m-d H:i:s',
                'comfort_category_id' => 'nullable|exists:App\Models\ComfortCategory,id',
                'car_model_id'        => 'nullable|exists:App\Models\CarModel,id',
            ];
        }

    }
