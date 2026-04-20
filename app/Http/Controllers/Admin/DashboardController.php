<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Review;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Stats
        $stats = [
            'popular_services' => Service::withCount('appointments')
                ->orderBy('appointments_count', 'desc')
                ->take(3)
                ->get(),
            'monthly_bookings' => Appointment::whereMonth('created_at', now()->month)->count(),
            'total_customers' => User::where('role', 'client')->count(),
            'total_services' => Service::count(),
            'portfolio_count' => \App\Models\Portfolio::count(),
        ];
        
        // Pending and confirmed appointments (active)
        $appointments = Appointment::with(['client', 'service'])
            ->whereIn('status', ['pending', 'confirmed'])
            ->orderBy('date')
            ->orderBy('created_at')
            ->take(10)
            ->get();
        
        // Completed and cancelled appointments (history)
        $appointmentHistory = Appointment::with(['client', 'service', 'review'])
            ->whereIn('status', ['completed', 'cancelled'])
            ->orderBy('date', 'desc')
            ->take(10)
            ->get();
        
        // Recent reviews
        $reviews = Review::with('user')
            ->latest()
            ->take(5)
            ->get();
        
        // Welcome message
        $welcome_message = \App\Models\Content::getValue(
            'admin_welcome_message', 
            'Lorem ipsum dolor sit amet et delectus accommodare his consul copiosae legendos at vix ad putent delectus delicata usu.'
        );
        
        return view('admin.dashboard', compact(
            'stats', 
            'appointments', 
            'appointmentHistory', 
            'reviews', 
            'welcome_message'
        ));
    }
    
    public function updateStatus(Request $request, Appointment $appointment)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,completed,cancelled',
        ]);
        
        $appointment->update(['status' => $request->status]);
        
        $statusMessages = [
            'confirmed' => 'Appointment confirmed!',
            'completed' => 'Appointment marked as complete!',
            'cancelled' => 'Appointment cancelled!',
            'pending' => 'Appointment set to pending!',
        ];
        
        $message = $statusMessages[$request->status] ?? 'Appointment status updated!';
        
        return back()->with('success', $message);
    }
}