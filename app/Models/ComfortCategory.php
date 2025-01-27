<?php

    namespace App\Models;


    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Relations\HasMany;
    use Illuminate\Database\Eloquent\Factories\HasFactory;

    class ComfortCategory extends Model
    {

        use HasFactory;

        /**
         * The attributes that are mass assignable.
         * @var array<int, string>
         */
        protected $fillable = [
            'comfort_category_name',
        ];

        public function positions(): HasMany
        {
            return $this->hasMany(Position::class);
        }

        public function carModels(): HasMany
        {
            return $this->hasMany(CarModel::class);
        }

    }
