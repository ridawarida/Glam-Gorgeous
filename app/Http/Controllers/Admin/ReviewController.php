<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::with('user')->latest()->paginate(20);
        return view('admin.reviews.index', compact('reviews'));
    }
    
    public function edit(Review $review)
    {
        return view('admin.reviews.edit', compact('review'));
    }
    
    public function update(Request $request, Review $review)
    {
        $review->update([
            'featured' => $request->has('featured'),
        ]);
        
        return redirect()->route('admin.reviews.index')
            ->with('success', 'Review updated successfully!');
    }
    
    public function toggleFeatured(Review $review)
    {
        $review->update([
            'featured' => !$review->featured,
        ]);
        
        return back()->with('success', 'Review ' . ($review->featured ? 'featured' : 'unfeatured') . '!');
    }
}