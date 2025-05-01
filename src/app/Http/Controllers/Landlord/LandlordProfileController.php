<?php

namespace App\Http\Controllers\Landlord;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Enums\ApprovalStatus;

class LandlordProfileController extends Controller
{
    public function show(): View
    {
        $user = auth()->user();

        if (!$user->landlord) {
            $user->landlord()->create([
                'approval_status' => ApprovalStatus::PENDING->value
            ]);
            $user->load('landlord');
        }

        return view('landlord.profile', compact('user'));
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'contact_number' => ['required', 'string', 'max:20'],
            'current_password' => ['required', 'current_password'],
        ]);

        $user = auth()->user();
        
        $user->update([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'contact_number' => $validated['contact_number'],
        ]);

        return back()->with('success', 'Profile updated successfully.');
    }








    public function uploadPermit(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'business_permit' => 'required|file|mimes:pdf|max:2048',
        ]);
    
        try {
            $user = auth()->user();
            $landlord = $user->landlord;
    
            if ($request->hasFile('business_permit')) {
                // Delete old file if exists
                if ($landlord->business_permit) {
                    Storage::disk('public')->delete($landlord->business_permit);
                }
    
                // Store file in public/permits directory
                $file = $request->file('business_permit');
                $path = $file->store('permits', 'public');
    
                // Update landlord record in database
                $landlord->update([
                    'business_permit' => $path,
                    'approval_status' => 'pending',
                    'rejection_remark' => null,
                    'updated_at' => now()
                ]);
    
                // Log successful upload
                \Log::info('Business permit uploaded:', [
                    'user_id' => $user->id,
                    'file_path' => $path
                ]);
    
                return back()->with('success', 'Business permit uploaded successfully. Please wait for admin verification.');
            }
    
            return back()->with('error', 'No file was uploaded.');
    
        } catch (\Exception $e) {
            \Log::error('Upload failed:', [
                'error' => $e->getMessage(),
                'user_id' => auth()->id()
            ]);
            
            return back()->with('error', 'Failed to upload business permit. Please try again.');
        }
    }
}