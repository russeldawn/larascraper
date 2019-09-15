<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Displays Welcome Page
     * @param Request $request
     * @return view
     */
    public function home(Request $request)
    {
        return view('scraper');
    }

    /**
     * Displays Welcome Page
     * @param Request $request
     * @return view
     */
    // public function child(Request $request)
    // {
    //     return view('child');
    // }

    /**
     *
     * @param Request $request
     * @return $request->user
     */
    public function me(Request $request)
    {
        return $request->user();
    }
}
