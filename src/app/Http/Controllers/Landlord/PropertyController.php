<?php
namespace App\Http\Controllers\Landlord;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\PropertyImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class PropertyController extends Controller
{
    public function index(Request $request)
    {
        $query = Property::with(['user', 'images']);
        
        // Apply owner filter
        if ($request->get('filter') === 'own') {
            $query->where('user_id', auth()->id());
        }

    
        // Apply type filter
        if ($type = $request->get('type')) {
            $query->where('type', $type);
        }
    
        // Apply available_for filter
        if ($availableFor = $request->get('available_for')) {
            $query->where('available_for', $availableFor);
        }
    
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
        return view('landlord.properties.index', compact('properties'));
    }

    public function create()
    {
        return view('landlord.properties.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:100',
            'description' => 'required|string|max:500',
            'contact_number' => 'required|string|size:11',
            'available_for' => 'required|in:male,female,couples,any',
            'type' => 'required|in:bedspace,house,room,apartment',
            'address' => 'required|string',
            'monthly_rent' => 'required|numeric|min:0',
            'images.*' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        try {
            DB::beginTransaction();

            $property = auth()->user()->properties()->create([
                'title' => $validated['title'],
                'description' => $validated['description'],
                'contact_number' => $validated['contact_number'],
                'available_for' => $validated['available_for'],
                'type' => $validated['type'],
                'address' => $validated['address'],
                'monthly_rent' => $validated['monthly_rent'],
            ]);

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $path = $image->store('property-images', 'public');
                    $property->images()->create(['image_path' => $path]);
                }
            }

            DB::commit();
            return redirect()->route('landlord.properties.index')
                ->with('success', 'Property listed successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to list property. Please try again.');
        }
    }

    public function edit(Property $property)
    {
        if (auth()->id() !== $property->user_id) {
            abort(403, 'Unauthorized action.');
        }

        return view('landlord.properties.edit', compact('property'));
    }











   public function update(Request $request, Property $property)
{
    if (auth()->id() !== $property->user_id) {
        abort(403, 'Unauthorized action.');
    }

    try {
        DB::beginTransaction();

        $validated = $request->validate([
            'title' => 'required|string|max:100',
            'description' => 'required|string|max:500',
            'contact_number' => 'required|string|size:11',
            'available_for' => 'required|in:male,female,couples,any',
            'type' => 'required|in:bedspace,house,room,apartment',
            'address' => 'required|string',
            'monthly_rent' => 'required|numeric|min:0',
            'images.*' => 'sometimes|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $property->update($validated);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('property-images', 'public');
                $property->images()->create([
                    'image_path' => $path
                ]);
            }
        }

        DB::commit();

        return back()->with('success', 'Property updated successfully');

    } catch (\Exception $e) {
        DB::rollBack();
        \Log::error('Property update failed', [
            'error' => $e->getMessage(),
            'property_id' => $property->id
        ]);

        return back()
            ->withInput()
            ->with('error', 'Failed to update property: ' . $e->getMessage());
    }
}










    public function destroy(Property $property)
    {
        if (auth()->id() !== $property->user_id) {
            abort(403, 'Unauthorized action.');
        }

        try {
            DB::beginTransaction();

            foreach ($property->images as $image) {
                Storage::disk('public')->delete($image->image_path);
            }

            $property->delete();

            DB::commit();
            return redirect()->route('landlord.properties.index')
                ->with('success', 'Property deleted successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to delete property. Please try again.');
        }
    }

    public function deleteImage(PropertyImage $image)
    {
        
        if (auth()->id() !== $image->property->user_id) {
            abort(403, 'Unauthorized action.');
        }

        Storage::disk('public')->delete($image->image_path);
        $image->delete();

        return back()->with('success', 'Image deleted successfully');
    }
    public function show(Property $property)
{
    return view('landlord.properties.show', compact('property'));
}
}