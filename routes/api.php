<?php


    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\CarController;

    /*
    |--------------------------------------------------------------------------
    | API Routes
    |--------------------------------------------------------------------------
    |
    | Here is where you can register API routes for your application. These
    | routes are loaded by the RouteServiceProvider and all of them will
    | be assigned to the "api" middleware group. Make something great!
    |
    */

    Route::middleware('auth:sanctum')->group(static function() {
        Route::get('/user', function(Request $request) {
            return $request->user();
        });

        Route::prefix('/v1')->group(static function() {
            Route::controller(CarController::class)->group(static function() {
                Route::get('/available-cars', 'getAvailableCars')->name('available_cars');
            });
        });
    });

