<?php

    namespace App\Models;


    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Relations\BelongsTo;
    use Illuminate\Database\Eloquent\Factories\HasFactory;

    class CarReservation extends Model
    {

        use HasFactory;

        /**
         * The attributes that are mass assignable.
         * @var array<int, string>
         */
        protected $fillable = [
            'car_id',
            'employee_id',
            'start_time',
            'end_time',
        ];

        protected $casts = [
            'start_time' => 'datetime',
            'end_time' => 'datetime',
        ];

        /**
         * @return BelongsTo|Car
         */
        public function car(): BelongsTo
        {
            return $this->belongsTo(Car::class);
        }

        /**
         * @return BelongsTo|Employee
         */
        public function employee(): BelongsTo
        {
            return $this->belongsTo(Employee::class);
        }

    }
