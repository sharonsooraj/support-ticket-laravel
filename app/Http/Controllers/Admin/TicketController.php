<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ticket;
use Illuminate\Support\Collection;

class TicketController extends Controller
{
    public function index()
    {
        $connections = ['technical', 'billing', 'product', 'feedback', 'general'];

        $allTickets = collect();


        foreach ($connections as $conn) {
            $tickets = Ticket::on($conn)->get();
            $allTickets = $allTickets->merge($tickets);
        }
        $typeCounts = [
            'Technical Issues' => 0,
            'Account & Billing' => 0,
            'Product & Service' => 0,
            'General Inquiry' => 0,
            'Feedback & Suggestions' => 0,
        ];

        foreach ($connections as $conn) {
            foreach (array_keys($typeCounts) as $type) {
                $typeCounts[$type] += Ticket::on($conn)->where('type', $type)->count();
            }
        }

        return view('admin.tickets', ['tickets' => $allTickets, 'typeCounts' => $typeCounts]);
    }


    public function show(Request $request)
    {
        $typeMapping = [
            'Technical Issues' => 'technical',
            'Account & Billing' => 'billing',
            'Product & Service' => 'product',
            'General Inquiry' => 'general',
            'Feedback & Suggestions' => 'feedback',
        ];

        $requestType = $request->type;
        $ticketId = $request->id;

        if (!array_key_exists($requestType, $typeMapping)) {
            return abort(404, 'Invalid ticket type provided');
        }

        $connectionName = $typeMapping[$requestType];

        $ticket = Ticket::on($connectionName)->find($ticketId);

        if (!$ticket) {
            return abort(404, 'Ticket not found');
        }
        return view('admin.ticketview', compact('ticket'));
    }


    public function update(Request $request)
    {

        $typeMapping = [
            'Technical Issues' => 'technical',
            'Account & Billing' => 'billing',
            'Product & Service' => 'product',
            'General Inquiry' => 'general',
            'Feedback & Suggestions' => 'feedback',
        ];


        $connectionName = $typeMapping[$request->type] ?? null;

        if (!$connectionName) {
            return redirect()->back()->with('error', 'Invalid ticket type.');
        }


        $ticket = Ticket::on($connectionName)->findOrFail($request->id);
        // Update note and status
        $ticket->note = $request->admin_note;

        if ($ticket->status === 'Pending') {
            $ticket->status = 'noted';
        }

        $ticket->save();


        return redirect()
            ->route('admin.tickets')
            ->with('success', 'Ticket updated successfully!');
    }




    public function destroy(Request $request)
    {

        $typeMapping = [
            'Technical Issues' => 'technical',
            'Account & Billing' => 'billing',
            'Product & Service' => 'product',
            'General Inquiry' => 'general',
            'Feedback & Suggestions' => 'feedback'
        ];


        $requestType = $request->type;


        if (!array_key_exists($requestType, $typeMapping)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid ticket type provided'
            ], 400);
        }

        $connectionName = $typeMapping[$requestType];
        $ticketId = $request->id;
        $deleted = Ticket::on($connectionName)
            ->where('id', $ticketId)
            ->delete();

        if (!$deleted) {
            $message = "Ticket with ID {$ticketId} not found in {$requestType} connection.";
            return redirect()->back()->with('error', $message);
        }
        return redirect()->back();
    }
}
