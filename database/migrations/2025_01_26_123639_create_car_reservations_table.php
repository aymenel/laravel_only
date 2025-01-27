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
            Schema::create('car_reservations', function(Blueprint $table) {
                $table->id();

                $table->unsignedBigInteger('car_id');
                $table->unsignedBigInteger('employee_id');

                $table->dateTime('start_time');
                $table->dateTime('end_time');

                $table->timestamps();

                $table->index('start_time');
                $table->index('end_time');

                $table->foreign('car_id')
                    ->references('id')
                    ->on('cars')
                ;
                $table->foreign('employee_id')
                    ->references('id')
                    ->on('employees')
                ;
            });
        }

        /**
         * Reverse the migrations.
         */
        public function down(): void
        {
            Schema::dropIfExists('car_reservations');
        }

    };
