<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\Message;

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

        // Save message to database
        Message::create([
            'first_name' => $validated['first_name'],
            'last_name'  => $validated['last_name'],
            'email'      => $validated['email'],
            'subject'    => $validated['subject'] ?? 'No Subject',
            'message'    => $validated['message'],
            'read'       => false,
        ]);

        return redirect()->route('contact.index')->with('success', true);
    }
}