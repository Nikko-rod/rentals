<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Enums\ApprovalStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class UserController extends Controller
{

    public function index(Request $request)
{
    $users = User::query()
        ->when($request->search, function ($query, $search) {
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        })
        ->when($request->role, function ($query, $role) {
            $query->where('role', $role);
        })
        ->when($request->status, function ($query, $status) {
            if ($status === 'pending') {
                $query->where('role', 'landlord')
                      ->whereHas('landlord', function($q) {
                          $q->where('approval_status', 'pending');
                      });
            } else {
                $query->where('is_archived', $status === 'archived');
            }
        })
        ->with('landlord')
        ->latest()
        ->paginate(10)
        ->withQueryString();

    return view('admin.manage-users', compact('users'));
}



public function edit(User $user)
{
    return view('admin.users.edit', compact('user'));
}


public function update(Request $request, User $user)
{
    $validated = $request->validate([
        'first_name' => ['required', 'string', 'max:255'],
        'last_name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'email', 'unique:users,email,' . $user->id],
        'contact_number' => ['required', 'string', 'regex:/^[0-9]{11}$/'],
    ]);

    $user->update($validated);

    return redirect()->route('admin.manage-users')
        ->with('success', 'User updated successfully');
}

public function toggleArchive(User $user)
{
    try {
        $user->update(['is_archived' => !$user->is_archived]);
        $status = $user->is_archived ? 'archived' : 'restored';
        
        return back()->with('success', "User has been {$status} successfully.");
    } catch (\Exception $e) {
        return back()->with('error', 'Failed to update user status.');
    }
}

    public function showPermit(User $user)
    {
        if (!$user->landlord || !$user->landlord->business_permit_path) {
            abort(404);
        }

        return Storage::response($user->landlord->business_permit_path);
    }


    public function approvePermit(User $user)
    {
        if (!$user->landlord) {
            abort(404);
        }
    
        try {
            DB::beginTransaction();
            
            $user->landlord->update([
                'approval_status' => ApprovalStatus::APPROVED,
                'rejection_remark' => null
            ]);
    
            DB::commit();
      
            // Change to back() instead of redirect to stay on current page
            return back()->with('success', 'Business permit approved successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Permit approval failed: ' . $e->getMessage());
            return back()->with('error', 'Failed to approve business permit: ' . $e->getMessage());
        }
    }


public function rejectPermit(Request $request, User $user)
{
    if (!$user->landlord) {
        abort(404);
    }

    $request->validate([
        'rejection_remark' => 'required|string|max:255'
    ]);

    try {
        DB::beginTransaction();
        
        $user->landlord->update([
            'approval_status' => ApprovalStatus::REJECTED,
            'rejection_remark' => $request->rejection_remark
        ]);

        DB::commit();
  
        return redirect()->route('admin.users.edit', $user)
                        ->with('success', 'Business permit rejected successfully');
    } catch (\Exception $e) {
        DB::rollBack();
        \Log::error('Permit rejection failed: ' . $e->getMessage());
        return redirect()->route('admin.users.edit', $user)
                        ->with('error', 'Failed to reject business permit: ' . $e->getMessage());
    }
}
}