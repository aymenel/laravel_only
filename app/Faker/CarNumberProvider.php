<?php

    namespace App\Faker;


    use Faker\Provider\Base;
    use Illuminate\Support\Arr;

    class CarNumberProvider extends Base
    {

        protected static $allowedLetters = [ 'а', 'в', 'е', 'к', 'м', 'н', 'о', 'р', 'с', 'т', 'у', 'х' ];

        public function randomCarNumber(): string
        {
            $region = $this->generator->numerify('###');
            $number = $this->generator->numerify('###');

            return Arr::random(self::$allowedLetters) . ' ' . $number . ' ' . Arr::random(self::$allowedLetters) . Arr::random(self::$allowedLetters) . ' ' . $region;
        }

    }
