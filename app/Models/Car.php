<?php

    namespace App\Models;


    use Illuminate\Database\Eloquent\Model;
    use SebastianBergmann\CodeCoverage\Driver\Driver;
    use Illuminate\Database\Eloquent\Relations\HasMany;
    use Illuminate\Database\Eloquent\Relations\BelongsTo;
    use Illuminate\Database\Eloquent\Factories\HasFactory;

    class Car extends Model
    {

        use HasFactory;

        /**
         * The attributes that are mass assignable.
         * @var array<int, string>
         */
        protected $fillable = [
            'number',
            'car_model_id',
            'driver_id',
        ];

        /**
         * @return BelongsTo|CarModel
         */
        public function carModel(): BelongsTo
        {
            return $this->belongsTo(CarModel::class);
        }

        public function driver(): BelongsTo
        {
            return $this->belongsTo(Employee::class);
        }

        public function carReservations(): HasMany
        {
            return $this->hasMany(CarReservation::class);
        }

    }
