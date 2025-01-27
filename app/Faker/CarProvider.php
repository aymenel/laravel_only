<?php

    namespace App\Faker;


    use Faker\Provider\Base;

    class CarProvider extends Base
    {

        protected static $carData = [
            "Audi"          => [
                "A1", "A3", "A4", "A5", "A6", "A7", "A8",
                "Q2", "Q3", "Q5", "Q7", "Q8",
                "TT", "R8",
            ],
            "BMW"           => [
                "1 Series", "2 Series", "3 Series", "4 Series", "5 Series", "6 Series", "7 Series", "8 Series",
                "X1", "X2", "X3", "X4", "X5", "X6", "X7",
                "Z4", "i3", "i4", "iX",
            ],
            "Mercedes-Benz" => [
                "A-Class", "C-Class", "E-Class", "S-Class",
                "CLA", "CLS", "GLA", "GLB", "GLC", "GLE", "GLS", "G-Class",
                "SL", "SLC", "GT", "EQC", "EQE", "EQS",
            ],
            "Volkswagen"    => [
                "Polo", "Golf", "Passat", "Arteon", "T-Cross", "T-Roc", "Tiguan", "Touareg",
                "ID.3", "ID.4", "ID.5", "ID.Buzz",
            ],
            "Toyota"        => [
                "Yaris", "Corolla", "Camry", "RAV4", "Highlander", "Land Cruiser", "Supra", "C-HR",
                "Prius", "GR86",
            ],
            "Nissan"        => [
                "Micra", "Juke", "Qashqai", "X-Trail", "Pathfinder", "GT-R",
                "Leaf", "Ariya",
            ],
            "Ford"          => [
                "Fiesta", "Focus", "Mondeo", "Kuga", "Puma", "Explorer", "Mustang",
                "Transit",
            ],
            "Hyundai"       => [
                "i10", "i20", "i30", "Elantra", "Tucson", "Santa Fe", "Kona",
                "IONIQ 5",
            ],
            "Kia"           => [
                "Picanto", "Rio", "Ceed", "Sportage", "Sorento", "Stinger", "EV6",
            ],
            "Tesla"         => [
                "Model 3", "Model S", "Model X", "Model Y",
            ],
            "Honda"         => [
                "Civic", "CR-V", "Accord", "HR-V", "Jazz",
            ],
            "Mazda"         => [
                "Mazda2", "Mazda3", "Mazda6", "CX-3", "CX-5", "MX-5",
            ],
            "Volvo"         => [
                "XC40", "XC60", "XC90", "S60", "V60", "C40 Recharge",
            ],
        ];

        public function randomCar(): string
        {
            $brand = array_rand(self::$carData);

            $model = self::$carData[$brand][array_rand(self::$carData[$brand])];

            return "$brand $model";
        }

        public function randomCarBrand(): string
        {
            return array_rand(self::$carData);
        }

        public function randomCarModel(string $brand): string
        {
            return self::$carData[$brand][array_rand(self::$carData[$brand])];
        }

    }
