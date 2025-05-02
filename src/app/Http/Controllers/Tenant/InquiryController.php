<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\Inquiry;
use App\Models\InquiryMessage;
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
            'message' => ['required', 'string', 'min:10', 'max:500']
        ]);

        $inquiry = Inquiry::create([
            'tenant_id' => auth()->id(),
            'landlord_id' => $property->user_id,
            'property_id' => $property->id,
            'quoted_monthly_rent' => $property->monthly_rent,
            'quoted_type' => $property->type,
            'message' => $validated['message'],
            'quoted_contact_number' => $property->contact_number
        ]);

        // Create initial message
        InquiryMessage::create([
            'inquiry_id' => $inquiry->id,
            'message' => $validated['message'],
            'is_landlord' => false
        ]);

        return back()->with('success', 'Inquiry sent successfully!');
    }

    public function show(Inquiry $inquiry)
    {
        abort_if($inquiry->tenant_id !== auth()->id(), 403);

        $messages = $inquiry->messages()
            ->orderBy('created_at')
            ->get();

        if (!$inquiry->read_at) {
            $inquiry->markAsRead();
        }

        return view('tenant.inquiries.show', compact('inquiry', 'messages'));
    }

        public function reply(Request $request, Inquiry $inquiry)
    {
        abort_if($inquiry->tenant_id !== auth()->id(), 403);
    
        // Check message count first
        $messageCount = $inquiry->messages()->count();
        if ($messageCount >= 10) {
            return back()->with('error', 'Maximum messages limit (10) reached.');
        }
    
        // Get the last message and check if tenant can reply
        $lastMessage = $inquiry->messages()->latest()->first();
        if (!$lastMessage) {
            // First message - tenant can reply
            $canReply = true;
        } else {
            // Can reply if last message was from landlord
            $canReply = $lastMessage->is_landlord;
        }
    
        if (!$canReply) {
            return back()->with('error', 'Please wait for landlord\'s response before sending another message.');
        }
    
        $validated = $request->validate([
            'message' => ['required', 'string', 'max:150']
        ]);
    
        $inquiry->messages()->create([
            'message' => $validated['message'],
            'is_landlord' => false,
            'created_at' => now()
        ]);
    
        return back()->with('success', 'Message sent successfully');
    }
}