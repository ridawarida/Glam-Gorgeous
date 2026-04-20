<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use App\Models\Category;
use App\Models\Favourite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PortfolioController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();
        
        // Before/After 
        $beforeAfterPairs = Portfolio::before()
            ->with(['afterImage', 'category'])
            ->latest()
            ->take(6)
            ->get();
        
        // Gallery query with category filter
        $query = Portfolio::gallery()->with('category');
        
        if ($request->has('category')) {
            $query->where('category_id', $request->category);
        }
        
        $gallery = $query->latest()->paginate(12);
        
        // User's favorites
        $favorites = collect();
        if (Auth::check() && Auth::user()->role === 'client') {
            $favorites = Portfolio::whereHas('favouritedBy', function($q) {
                $q->where('client_id', Auth::id());
            })->with('category')->get();
        }
        
        return view('portfolio', compact(
            'categories', 
            'beforeAfterPairs', 
            'gallery', 
            'favorites' 
        ));
    }
    
    public function toggleFavorite(Request $request, Portfolio $portfolio)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Please login'], 401);
        }
        
        $user = Auth::user();
        $exists = Favourite::where('client_id', $user->id)
            ->where('portfolio_id', $portfolio->id)
            ->exists();
        
        if ($exists) {
            Favourite::where('client_id', $user->id)
                ->where('portfolio_id', $portfolio->id)
                ->delete();
            $favorited = false;
        } else {
            Favourite::create([
                'client_id' => $user->id,
                'portfolio_id' => $portfolio->id,
            ]);
            $favorited = true;
        }
        
        return response()->json([
            'success' => true,
            'favorited' => $favorited
        ]);
    }
}