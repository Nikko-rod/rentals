<?php

namespace App\Http\Controllers\Landlord;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use Illuminate\Http\Request;

class InquiryController extends Controller
{
    public function index()
    {
        $inquiries = auth()->user()
            ->receivedInquiries()
            ->with(['property', 'tenant'])
            ->latest()
            ->paginate(10);

        return view('landlord.inquiries.index', compact('inquiries'));
    }

    public function update(Request $request, Inquiry $inquiry)
{
    $request->validate([
        'status' => ['required', 'in:accepted,rejected'],
        'response' => ['nullable', 'string', 'max:500']
    ]);

    if (!$inquiry->read_at) {
        $inquiry->read_at = now();
    }

    $inquiry->status = $request->status;
    
    if ($request->filled('response')) {
        $inquiry->landlord_response = $request->response;
        $inquiry->responded_at = now();
    }

    $inquiry->save();

    return back()->with('success', 'Inquiry updated successfully!');
}


public function show(Inquiry $inquiry)
{
    abort_if($inquiry->landlord_id !== auth()->id(), 403);
    
    $messages = $inquiry->messages()
        ->orderBy('created_at')
        ->get();

    if (!$inquiry->read_at) {
        $inquiry->markAsRead();
    }

    return view('landlord.inquiries.show', compact('inquiry', 'messages'));
}


public function reply(Request $request, Inquiry $inquiry)
{
    abort_if($inquiry->landlord_id !== auth()->id(), 403);

    // Check if messages exist and if last message was from landlord
    $lastMessage = $inquiry->messages()->latest()->first();
    if ($lastMessage && $lastMessage->is_landlord) {
        return back()->with('error', 'Please wait for tenant\'s response before sending another message.');
    }

    $validated = $request->validate([
        'message' => ['required', 'string', 'max:150']
    ]);

    $inquiry->messages()->create([
        'message' => $validated['message'],
        'is_landlord' => true
    ]);

    return back()->with('success', 'Message sent successfully');
}
}