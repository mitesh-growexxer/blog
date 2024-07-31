<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function index(){
        $data = [];
        $data['pageTitle'] = trans('messages.dashboard');
        return view('dashboard' , $data );
    }
}
