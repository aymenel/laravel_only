<?php


    use Illuminate\Support\Facades\Schema;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Database\Migrations\Migration;

    return new class extends Migration {

        /**
         * Run the migrations.
         */
        public function up(): void
        {
            Schema::create('cars', function(Blueprint $table) {
                $table->id();

                $table->string('number', 20)
                    ->unique()
                ;
                $table->unsignedBigInteger('car_model_id');
                $table->unsignedBigInteger('driver_id')
                    ->nullable()
                ;

                $table->timestamps();

                $table->foreign('car_model_id')
                    ->references('id')
                    ->on('car_models')
                    ->onDelete('cascade')
                ;
                $table->foreign('driver_id')
                    ->references('id')
                    ->on('employees')
                    ->onDelete('cascade')
                ;
            });
        }

        /**
         * Reverse the migrations.
         */
        public function down(): void
        {
            Schema::dropIfExists('cars');
        }

    };
