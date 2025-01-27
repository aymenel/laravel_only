<?php

    namespace App\Models;


    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Relations\HasMany;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Relations\BelongsToMany;
    use Illuminate\Database\Eloquent\Relations\HasManyThrough;

    class Position extends Model
    {

        use HasFactory;

        /**
         * The attributes that are mass assignable.
         * @var array<int, string>
         */
        protected $fillable = [
            'position_name',
        ];

        public function employees(): HasMany
        {
            return $this->hasMany(Employee::class);
        }

        public function comfortCategories(): BelongsToMany
        {
            return $this->belongsToMany(ComfortCategory::class);
        }

    }
