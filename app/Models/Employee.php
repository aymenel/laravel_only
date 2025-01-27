<?php

    namespace App\Models;


    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Relations\HasMany;
    use Illuminate\Database\Eloquent\Relations\BelongsTo;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Relations\BelongsToMany;

    class Employee extends Model
    {

        use HasFactory;

        /**
         * The attributes that are mass assignable.
         * @var array<int, string>
         */
        protected $fillable = [
            'surname',
            'name',
            'patronymic',
            'user_id',
        ];

        /**
         * @return BelongsTo|User|null
         */
        public function user(): BelongsTo
        {
            return $this->belongsTo(User::class);
        }

        /**
         * @return BelongsTo|Position
         */
        public function positions(): BelongsToMany
        {
            return $this->belongsToMany(Position::class);
        }

        public function getFullNameAttribute(): string
        {
            return $this->surname . ' ' . $this->name . ' ' .$this->patronymic;
        }

    }
