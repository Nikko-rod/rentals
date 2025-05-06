<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\Inquiry;
use Illuminate\Http\Request;

class InquiryController extends Controller
{
    public function index()
    {
        $inquiries = Inquiry::where('tenant_id', auth()->id())
            ->with(['property', 'messages'])
            ->latest()
            ->paginate(10);

        return view('tenant.inquiries.index', compact('inquiries'));
    }

    public function store(Request $request, Property $property)
    {
        $validated = $request->validate([
            'message' => ['required', 'string', 'min:10', 'max:250']
        ]);

        $inquiry = Inquiry::create([
            'tenant_id' => auth()->id(),
            'landlord_id' => $property->user_id,
            'property_id' => $property->id,
            'quoted_monthly_rent' => $property->monthly_rent,
            'quoted_type' => $property->type,
            'quoted_contact_number' => $property->contact_number,
            'message' => $validated['message']
        ]);

        // Add initial message using new method
        $inquiry->addMessage($validated['message'], false);

        return back()->with('success', 'Inquiry sent successfully!');
    }

    public function reply(Request $request, Inquiry $inquiry)
{
    abort_if($inquiry->tenant_id !== auth()->id(), 403);

    // Get fresh message count
    if (!$inquiry->canAddMoreMessages()) {
        return back()->with('error', 'Maximum messages limit (10) reached.');
    }

    // Get fresh last message to check turn
    $lastMessage = $inquiry->messages()
        ->orderBy('created_at', 'desc')
        ->orderBy('id', 'desc')
        ->first();

    if ($lastMessage && !$lastMessage->is_landlord) {
        return back()->with('error', 'Please wait for landlord\'s response before sending another message.');
    }

    $validated = $request->validate([
        'message' => ['required', 'string', 'max:150']
    ]);

    try {
        $message = $inquiry->addMessage($validated['message'], false);
        
        \Log::info('Message Created', [
            'message_id' => $message->id,
            'inquiry_id' => $inquiry->id,
            'is_landlord' => false,
            'created_at' => $message->created_at->toDateTimeString()
        ]);

        return back()->with('success', 'Message sent successfully');
    } catch (\Exception $e) {
        \Log::error('Failed to create message', [
            'error' => $e->getMessage(),
            'inquiry_id' => $inquiry->id
        ]);
        
        return back()->with('error', 'Failed to send message. Please try again.');
    }
}



    public function show(Inquiry $inquiry)
    {
        abort_if($inquiry->tenant_id !== auth()->id(), 403);
    
        // Force fresh loading of messages with strict ordering
        $messages = $inquiry->messages()
            ->orderBy('created_at', 'asc')
            ->orderBy('id', 'asc')  // Secondary ordering by ID for same timestamps
            ->get();
        
        // Get fresh last message
        $lastMessage = $messages->last();
    
        // Debug logging with more details
        \Log::info('Show Inquiry Debug', [
            'inquiry_id' => $inquiry->id,
            'user_id' => auth()->id(),
            'user_role' => auth()->user()->role,
            'message_count' => $messages->count(),
            'all_messages' => $messages->map(fn($msg) => [
                'id' => $msg->id,
                'is_landlord' => (bool) $msg->is_landlord,
                'message' => $msg->message,
                'created_at' => $msg->created_at->toDateTimeString()
            ])->toArray(),
            'can_reply' => $inquiry->canReply()
        ]);
    
        if ($inquiry->isUnread()) {
            $inquiry->markAsRead();
        }
    
        return view('tenant.inquiries.show', compact('inquiry', 'messages'));
    }
}