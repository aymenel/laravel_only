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
            Schema::create('comfort_category_position', function(Blueprint $table) {
                $table->unsignedBigInteger('position_id');
                $table->unsignedBigInteger('comfort_category_id');

                $table->primary(['position_id', 'comfort_category_id']);

                $table->foreign('position_id')
                    ->references('id')
                    ->on('positions')
                    ->onDelete('cascade')
                ;
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
            Schema::dropIfExists('comfort_category_position');
        }

    };
