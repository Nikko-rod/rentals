<?php
namespace App\Http\Controllers\Landlord;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\PropertyImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Purifier;

class PropertyController extends Controller
{
    public function index(Request $request)
    {
        $query = Property::with(['user', 'images']);
        
        if ($request->get('filter') === 'own') {
            $query->where('user_id', auth()->id());
        }


        if ($type = $request->get('type')) {
            $query->where('type', $type);
        }
    
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
        
        $properties = $query->paginate(12)->withQueryString();
        return view('landlord.properties.index', compact('properties'));
    }

    public function create()
    {
        return view('landlord.properties.create');
    }

   
public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:100',
        'description' => 'required|string|max:5000', // Increased for HTML content
        'contact_number' => 'required|string|regex:/^[0-9]{11}$/',
        'monthly_rent' => 'required|numeric|min:0',
        'type' => 'required|in:bedspace,room,apartment,house',
        'available_for' => 'required|in:male,female,couples,any',
        'address' => 'required|string',
        'images.*' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        'images' => 'required|array|min:1|max:5',
    ]);

    try {
        DB::beginTransaction();

        // Sanitize HTML from Summernote
        $sanitizedDescription = Purifier::clean($request->description, [
            'HTML.Allowed' => 'p,b,strong,i,em,u,ul,ol,li,br,h2,h3,h4',
            'HTML.Nofollow' => true,
            'HTML.TargetBlank' => true,
            'AutoFormat.RemoveEmpty' => true,
        ]);

        $property = Property::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'description' => $sanitizedDescription,
            'contact_number' => $request->contact_number,
            'monthly_rent' => $request->monthly_rent,
            'type' => $request->type,
            'available_for' => $request->available_for,
            'address' => $request->address,
            'is_available' => true,
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('property-images', 'public');
                $property->images()->create([
                    'image_path' => $path
                ]);
            }
        }

       DB::commit();
        return redirect()
            ->route('landlord.properties.index')
            ->with('success', 'Property created successfully!');

    } catch (\Exception $e) {
        DB::rollBack();
        \Log::error('Property creation failed', [
            'error' => $e->getMessage(),
            'request' => $request->except(['images'])
        ]);
        return back()
            ->withInput()
            ->with('error', 'Failed to create property. Please try again.');
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
            'description' => 'required|string|max:5000', // Increased for HTML content
            'contact_number' => 'required|string|size:11',
            'available_for' => 'required|in:male,female,couples,any',
            'type' => 'required|in:bedspace,house,room,apartment',
            'is_available' => 'sometimes|boolean',
            'address' => 'required|string',
            'monthly_rent' => 'required|numeric|min:0',
            'images.*' => 'sometimes|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // Sanitize HTML from Summernote
        $validated['description'] = Purifier::clean($request->description, [
            'HTML.Allowed' => 'p,b,strong,i,em,u,ul,ol,li,br,h2,h3,h4',
            'HTML.Nofollow' => true,
            'HTML.TargetBlank' => true,
            'AutoFormat.RemoveEmpty' => true,
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
        return redirect()
            ->route('landlord.properties.show', $property)
            ->with('success', 'Property updated successfully!');

    } catch (\Exception $e) {
        DB::rollBack();
        \Log::error('Property update failed', [
            'error' => $e->getMessage(),
            'property_id' => $property->id
        ]);
        return back()
            ->withInput()
            ->with('error', 'Failed to update property. Please try again.');
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