<?php

namespace App\Http\Controllers;

use App\Helpers\WebRequest;
use Chumper\Zipper\Facades\Zipper;
use Illuminate\Http\Request;
use phpseclib\Net\SSH2;

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
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
//        $app = new WebRequest([
//            "name" => "aval",
//            "host" => "185.51.202.111",
//            "port" => "22"
//        ], "/");
//        $app->run();


        return view('admin.dashboard');
    }
}
