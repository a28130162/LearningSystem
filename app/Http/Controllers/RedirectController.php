<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectController extends Controller
{
    public function __invoke(){
        if(Auth::check()){
            if(Auth::user()->role=='admin'){
                return redirect('/management');
            }
            else{
                return redirect('/course');
            }
        }
        else{
            return redirect('/');
        }
    }
}
