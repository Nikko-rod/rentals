<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\PropertyImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class AdminPropertyController extends Controller
{
    public function index(Request $request)
    {
        $query = Property::with(['owner', 'images']);

        // Filtering
        if ($type = $request->get('type')) {
            $query->where('type', $type);
        }
    
        if ($availableFor = $request->get('available_for')) {
            $query->where('available_for', $availableFor);
        }
    
        // Sorting
        if ($sort = $request->get('sort')) {
            if ($sort === 'highest') {
                $query->orderBy('monthly_rent', 'desc');
            } elseif ($sort === 'lowest') {
                $query->orderBy('monthly_rent', 'asc');
            }
        } else {
            $query->latest();
        }
        
        $properties = $query->paginate(10)->withQueryString();
        return view('admin.properties.index', compact('properties'));
    }

    public function show(Property $property)
    {
        $property->load(['owner', 'images']);
        return view('admin.properties.show', compact('property'));
    }

    public function destroy(Property $property)
{
    try {
        DB::beginTransaction();

       
        foreach ($property->images as $image) {
            if (Storage::disk('public')->exists($image->path)) {
                Storage::disk('public')->delete($image->path);
            }
            $image->delete();
        }

        $property->delete();

        DB::commit();
        
        return redirect()
            ->route('admin.properties.index')
            ->with('success', 'Property deleted successfully');

    } catch (\Exception $e) {
        DB::rollBack();
        \Log::error('Property deletion failed', [
            'error' => $e->getMessage(),
            'property_id' => $property->id
        ]);

        return back()->with('error', 'Failed to delete property. Please try again.');
    }
}
}