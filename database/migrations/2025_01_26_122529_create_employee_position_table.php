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
            Schema::create('employee_position', function(Blueprint $table) {
                $table->unsignedBigInteger('employee_id');
                $table->unsignedBigInteger('position_id');

                $table->unique(['employee_id', 'position_id']);

                $table->foreign('employee_id')
                    ->references('id')
                    ->on('employees')
                    ->onDelete('cascade')
                ;
                $table->foreign('position_id')
                    ->references('id')
                    ->on('positions')
                    ->onDelete('cascade')
                ;
            });
        }

        /**
         * Reverse the migrations.
         */
        public function down(): void
        {
            Schema::dropIfExists('employee_position');
        }

    };
