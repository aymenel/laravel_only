<?php

    namespace App\Http\Controllers;


    use Illuminate\Contracts\View\View;

    class PositionController extends Controller
    {

        public function index(): View
        {
            return view('reservation.positions');
        }

    }
