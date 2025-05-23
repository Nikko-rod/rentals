<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Property;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    public function index(Request $request)
    {
        $query = Property::with(['user', 'images'])
        ->select('properties.*');
            
        if ($search = $request->get('search')) {
            $query->where('title', 'like', "%{$search}%");
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
        return view('tenant.properties.index', compact('properties'));
    }

    public function show(Property $property)
{
    return view('tenant.properties.show', compact('property'));
}


}