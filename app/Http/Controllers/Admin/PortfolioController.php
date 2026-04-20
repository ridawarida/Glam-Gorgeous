<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PortfolioController extends Controller
{
    public function index()
    {
        $portfolio = Portfolio::with('category')->latest()->paginate(20);
        return view('admin.portfolio.index', compact('portfolio'));
    }
    
    public function create()
    {
        $categories = Category::all();
        $galleryImages = Portfolio::gallery()->get();
        return view('admin.portfolio.create', compact('categories', 'galleryImages'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'alt_text' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'is_before' => 'nullable|boolean',
            'after_image_id' => 'nullable|exists:portfolio,id',
        ]);
        
         $extension = $request->file('image')->getClientOriginalExtension();
            $filename = uniqid() . '.' . $extension;
            $path = $request->file('image')->storeAs('portfolio', $filename, 'public');

        Portfolio::create([
            'image_path' => $path,
            'alt_text' => $request->alt_text,
            'category_id' => $request->category_id,
            'is_before' => $request->boolean('is_before'),
            'after_image_id' => $request->after_image_id,
        ]);
        
        return redirect()->route('admin.portfolio.index')
            ->with('success', 'Image uploaded successfully!');
    }
    
    public function edit(Portfolio $portfolio)
    {
        $categories = Category::all();
        $galleryImages = Portfolio::where('id', '!=', $portfolio->id)->get();
        return view('admin.portfolio.edit', compact('portfolio', 'categories', 'galleryImages'));
    }
    
    public function update(Request $request, Portfolio $portfolio)
    {
        $request->validate([
            'alt_text' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'is_before' => 'nullable|boolean',
            'after_image_id' => 'nullable|exists:portfolio,id',
        ]);
        
        // Handle new image upload
        if ($request->hasFile('image')) {
            $request->validate([
                'image' => 'image|mimes:jpeg,png,jpg,gif,webp|max:5120'
            ]);
            
            if ($portfolio->image_path) {
                Storage::disk('public')->delete($portfolio->image_path);
            }
            
            $path = $request->file('image')->store('portfolio', 'public');
            $portfolio->image_path = $path;
        }
        
        $portfolio->update([
            'alt_text' => $request->alt_text,
            'category_id' => $request->category_id,
            'is_before' => $request->boolean('is_before'),
            'after_image_id' => $request->after_image_id,
        ]);
        
        return redirect()->route('admin.portfolio.index')
            ->with('success', 'Image updated successfully!');
    }
    
    public function destroy(Portfolio $portfolio)
    {
        $portfolio->delete();
        
        return redirect()->route('admin.portfolio.index')
            ->with('success', 'Image deleted successfully!');
    }
    
    public function toggleBefore(Portfolio $portfolio)
    {
        $portfolio->update([
            'is_before' => !$portfolio->is_before,
            'after_image_id' => $portfolio->is_before ? null : $portfolio->after_image_id,
        ]);
        
        return back()->with('success', 'Image status updated!');
    }
    
    public function linkPair(Request $request)
    {
        $request->validate([
            'before_id' => 'required|exists:portfolio,id',
            'after_id' => 'required|exists:portfolio,id|different:before_id',
        ]);
        
        $before = Portfolio::find($request->before_id);
        $before->update([
            'is_before' => true,
            'after_image_id' => $request->after_id,
        ]);
        
        return back()->with('success', 'Before/After pair linked successfully!');
    }
}