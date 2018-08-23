<?php

namespace App\Http\Controllers;

use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RuntimeException;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return redirect()->route('admin',['id'=>Auth::id()]);
    }

    public function bugsnag()
    {
        Bugsnag::notifyException(new RuntimeException("Test error"));
        return "Error reported to Bugsnag!";
    }

    public function redirectWelcomePage()
    {

        return "Redirect!";
    }

}
