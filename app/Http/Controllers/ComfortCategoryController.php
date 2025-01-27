<?php

    namespace App\Http\Controllers;


    use Illuminate\Contracts\View\View;

    class ComfortCategoryController extends Controller
    {

        public function index(): View
        {
            return view('reservation.comfort_categories');
        }

    }
