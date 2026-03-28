<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Productdetail1Controller extends Controller
{
    public function detail1($slug)
    {
        return view('product-detail1');
    }
}
