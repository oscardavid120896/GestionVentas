<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class ProfesorController extends Controller
{
        /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth','verified']);
        $this->middleware('profesor');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function indexP()
    {
        return view('profesor.home');
    }
}
