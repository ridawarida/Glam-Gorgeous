<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Category;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function show(Service $service)
    {
        return response()->json($service);
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'duration_minutes' => 'nullable|integer|min:1',
            'category_id' => 'required|exists:categories,id',
            'availability' => 'boolean',
        ]);
        
        Service::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'duration_minutes' => $request->duration_minutes ?? 60,
            'category_id' => $request->category_id,
            'availability' => $request->has('availability'),
        ]);
        
        return redirect()->route('services')->with('success', 'Service added successfully!');
    }
    
    public function update(Request $request, Service $service)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'duration_minutes' => 'nullable|integer|min:1',
            'category_id' => 'required|exists:categories,id',
            'availability' => 'boolean',
        ]);
        
        $service->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'duration_minutes' => $request->duration_minutes ?? 60,
            'category_id' => $request->category_id,
            'availability' => $request->has('availability'),
        ]);
        
        return redirect()->route('services')->with('success', 'Service updated successfully!');
    }
    
    public function destroy(Service $service)
    {
        $service->delete();
        return redirect()->route('services')->with('success', 'Service deleted successfully!');
    }
}