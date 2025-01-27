<?php

    namespace App\Models;


    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Relations\HasMany;
    use Illuminate\Database\Eloquent\Relations\BelongsTo;
    use Illuminate\Database\Eloquent\Factories\HasFactory;

    class CarModel extends Model
    {

        use HasFactory;

        /**
         * The attributes that are mass assignable.
         * @var array<int, string>
         */
        protected $fillable = [
            'model_name',
            'comfort_category_id'
        ];

        public function comfortCategory(): BelongsTo
        {
            return $this->belongsTo(ComfortCategory::class);
        }

    }
