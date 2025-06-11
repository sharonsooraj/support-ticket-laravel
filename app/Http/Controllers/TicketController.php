<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TicketController extends Controller
{
    public function index()
    {
        return view('tickets/ticket-form');
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'subject' => 'required',
            'message' => 'required',
            'type' => 'required',
        ]);

        $db = match($validated['type']) {
            'Technical Issues' => 'technical',
            'Account & Billing' => 'billing',
            'Product & Service' => 'product',
            'Feedback & Suggestions' => 'feedback',
            default => 'general',
        };

        DB::connection($db)->table('tickets')->insert([
            ...$validated,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('ticket.success');

    }

}
