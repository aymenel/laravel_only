<?php

    namespace App\Http\Controllers;


    use Illuminate\Contracts\View\View;

    class EmployeeController extends Controller
    {

        public function index(): View
        {
            return view('reservation.employees');
        }

    }
