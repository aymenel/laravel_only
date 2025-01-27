<?php


    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\CarController;
    use App\Http\Controllers\EmployeeController;
    use App\Http\Controllers\PositionController;
    use App\Http\Controllers\ComfortCategoryController;

    /*
    |--------------------------------------------------------------------------
    | Web Routes
    |--------------------------------------------------------------------------
    |
    | Here is where you can register web routes for your application. These
    | routes are loaded by the RouteServiceProvider and all of them will
    | be assigned to the "web" middleware group. Make something great!
    |
    */

    Route::view('/', 'welcome');

    Route::middleware('auth')->group(static function() {
        Route::view('profile', 'profile')
            ->name('profile')
        ;

        Route::middleware('verified')->group(static function() {
            Route::view('dashboard', 'dashboard')
                ->name('dashboard')
            ;

            Route::prefix('/reservation')->name('reservation.')->group(static function() {
                Route::get('/employees', [ EmployeeController::class, 'index' ])
                    ->name('employees')
                ;

                Route::get('/positions', [ PositionController::class, 'index' ])
                    ->name('positions')
                ;

                Route::get('/comfort-categories', [ ComfortCategoryController::class, 'index' ])
                    ->name('comfort_categories')
                ;

                Route::controller(CarController::class)->group(static function() {
                    Route::get('/cars', 'indexCars')->name('cars');
                    Route::get('/car-reservation', 'indexCarReservations')->name('car_reservations');
                    Route::get('/car-search', 'indexCarSearch')->name('car_search');
                });
            });
        });
    });

    require __DIR__ . '/auth.php';
