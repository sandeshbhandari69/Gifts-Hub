<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index()
    {
        return view('contact');
    }

    public function send(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name'  => 'required|string|max:100',
            'email'      => 'required|email',
            'subject'    => 'nullable|string|max:255',
            'message'    => 'required|string',
        ]);

        // Option B: Just redirect back with success (no mail setup needed)
        return redirect()->route('contact.index')->with('success', true);
    }
}