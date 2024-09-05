<?php

namespace App\Http\Controllers;

use App\Mail\ContactMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'subject'=> 'required',
            'message' => 'required',
        ]);

        // Send the email
        Mail::to('mohamedpipocherajawi@gmail.com')->send(new ContactMail($request->all()));

        return back()->with('success', 'Your message has been sent successfully!');
    }
}
