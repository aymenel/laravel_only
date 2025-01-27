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
            Schema::create('car_models', function(Blueprint $table) {
                $table->id();

                $table->string('model_name')
                    ->unique()
                ;
                $table->unsignedBigInteger('comfort_category_id');

                $table->timestamps();

                $table->foreign('comfort_category_id')
                    ->references('id')
                    ->on('comfort_categories')
                    ->onDelete('cascade')
                ;
            });
        }

        /**
         * Reverse the migrations.
         */
        public function down(): void
        {
            Schema::dropIfExists('car_models');
        }

    };
