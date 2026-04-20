<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Service;
use App\Models\Review;
use App\Models\Portfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    // Customer Dashboard
    public function dashboard()
    {
        $user = Auth::user();
        
        // Upcoming appointments
        $upcomingAppointments = Appointment::where('client_id', $user->id)
            ->whereIn('status', ['pending', 'confirmed'])
            ->where('date', '>=', now())
            ->with('service')
            ->orderBy('date')
            ->get();
        
        // Appointment history
        $appointmentHistory = Appointment::where('client_id', $user->id)
            ->where(function($query) {
                $query->where('status', 'completed')
                      ->orWhere('date', '<', now());
            })
            ->with(['service', 'review'])
            ->orderBy('date', 'desc')
            ->get();

        
        // Favorite looks
        $favorites = Portfolio::whereHas('favouritedBy', function($q) use ($user) {
            $q->where('client_id', $user->id);
        })->with('category')->latest()->take(3)->get();
        
        return view('dashboard', compact(
            'user',
            'upcomingAppointments',
            'appointmentHistory',
            'favorites'
        ));
    }
    
    
    // Booking form
    public function create()
    {
        $services = Service::where('availability', true)->get();
        return view('booking.create', compact('services'));
    }
    
    // Submit booking
    public function store(Request $request)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'event_type' => 'required|string',
            'location' => 'required|string',
            'date' => 'required|date|after:today',
            'instruction' => 'nullable|string',
        ]);
        
        Appointment::create([
            'client_id' => Auth::id(),
            'service_id' => $request->service_id,
            'event_type' => $request->event_type,
            'location' => $request->location,
            'date' => $request->date,
            'instruction' => $request->instruction,
            'status' => 'pending',
        ]);
        
        return redirect()->route('dashboard')->with('success', 'Booking request submitted!');
    }
    
    // Cancel booking
    public function cancel($id)
    {
        $appointment = Appointment::where('client_id', Auth::id())
            ->where('id', $id)
            ->whereIn('status', ['pending', 'confirmed'])
            ->firstOrFail();
            
        $appointment->update(['status' => 'cancelled']);
        
        return back()->with('success', 'Booking cancelled.');
    }
    
    // Submit review for completed appointment
    public function submitReview(Request $request, Appointment $appointment)
    {
        if ($appointment->client_id !== Auth::id()) {
            abort(403);
        }
        
        if ($appointment->status !== 'completed') {
            return back()->with('error', 'You can only review completed appointments.');
        }
        
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'content' => 'required|string|min:10|max:1000',
        ]);
        
        // Create or update review
        Review::updateOrCreate(
            ['appointment_id' => $appointment->id],
            [
                'user_id' => Auth::id(),
                'rating' => $request->rating,
                'content' => $request->content,
            ]
        );
        
        return back()->with('success', 'Thank you for your review!');
    }
}