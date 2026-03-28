<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Productdetail2Controller extends Controller
{
    public function detail2($slug)
    {
        return view('product-detail2');
    }
}
