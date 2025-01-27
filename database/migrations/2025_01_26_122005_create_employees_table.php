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
            Schema::create('employees', function(Blueprint $table) {
                $table->id();

                $table->string('surname');
                $table->string('name');
                $table->string('patronymic');

                $table->unsignedBigInteger('user_id')
                    ->nullable()
                    ->index()
                ;

                $table->timestamps();

                $table->foreign('user_id')
                    ->references('id')
                    ->on('users')
                    ->onDelete('cascade')
                ;
            });
        }

        /**
         * Reverse the migrations.
         */
        public function down(): void
        {
            Schema::dropIfExists('employees');
        }

    };
