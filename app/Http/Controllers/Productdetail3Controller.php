<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Productdetail3Controller extends Controller
{
    public function detail3($slug)
    {
        return view('product-detail3');
    }
}
