@extends('layouts.app')

@section('title', 'My Dashboard')

@section('content')
<div class="container py-4">
    <!-- Welcome Section -->
    <div class="row mb-5">
        <div class="col-12">
            <span class="text-uppercase text-muted small fw-bold">Welcome back</span>
            <h1 class="display-5 fw-bold">Welcome, {{ $user->name }}!</h1>
            <p class="lead text-secondary">
                Manage your appointments, view your favorite looks, and leave reviews all in one place.
            </p>
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('booking.create') }}" class="btn btn-dark">
                    <i class="bi bi-calendar-plus"></i> Book New Appointment
                </a>
                <a href="{{ route('portfolio') }}" class="btn btn-outline-dark">
                    <i class="bi bi-images"></i> Browse Portfolio
                </a>
                <a href="{{ route('services') }}" class="btn btn-outline-dark">
                    <i class="bi bi-list"></i> View Services
                </a>
            </div>
        </div>
    </div>
    
    <!-- Your Favourite Looks -->
    <section class="mb-5">
        <h2 class="h4 fw-bold mb-3">Your Favourite Looks</h2>
        @if($favorites->count() > 0)
            <div class="row g-4">
                @foreach($favorites as $item)
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <img src="{{ $item->image_url }}" class="card-img-top" style="height: 200px; object-fit: cover;" alt="{{ $item->alt_text }}">
                        <div class="card-body">
                            <p class="fw-medium mb-1">{{ Str::limit($item->alt_text, 40) }}</p>
                            <span class="badge bg-secondary">{{ $item->category->name ?? 'Uncategorized' }}</span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="mt-3">
                <a href="{{ route('portfolio') }}" class="text-decoration-none">
                    Browse more <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        @else
            <div class="bg-light p-4 rounded text-center">
                <p class="text-secondary mb-2">You haven't saved any favorites yet.</p>
                <a href="{{ route('portfolio') }}" class="btn btn-outline-dark btn-sm">Browse Portfolio</a>
            </div>
        @endif
    </section>
    
    <!-- Upcoming Appointments -->
<section class="mb-5">
    <h2 class="h4 fw-bold mb-3">Upcoming Appointments</h2>
    @if($upcomingAppointments->count() > 0)
        <div class="row g-4">
            @foreach($upcomingAppointments as $appointment)
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h5 class="card-title">{{ $appointment->service->name }}</h5>
                            <span class="badge bg-{{ $appointment->status === 'confirmed' ? 'success' : 'warning' }}">
                                {{ ucfirst($appointment->status) }}
                            </span>
                        </div>
                        <p class="card-text text-secondary mb-1">
                            <i class="bi bi-calendar me-2"></i>{{ $appointment->date->format('l, F j, Y') }}
                        </p>
                        <p class="card-text text-secondary mb-1">
                            <i class="bi bi-tag me-2"></i>{{ $appointment->event_type }}
                        </p>
                        <p class="card-text text-secondary mb-3">
                            <i class="bi bi-geo-alt me-2"></i>{{ Str::limit($appointment->location, 30) }}
                        </p>
                        
                        @if($appointment->status === 'pending')
                        <form action="{{ route('booking.cancel', $appointment->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Cancel this appointment?')">
                                Cancel Request
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @else
        <div class="bg-light p-4 rounded text-center">
            <p class="text-secondary mb-2">No upcoming appointments.</p>
            <a href="{{ route('booking.create') }}" class="btn btn-dark btn-sm">Book Now</a>
        </div>
    @endif
</section>
    
    <!-- Appointment History -->
<section class="mb-5">
    <h2 class="h4 fw-bold mb-3">Appointment History</h2>
    @if($appointmentHistory->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Service</th>
                        <th>Date</th>
                        <th>Event</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($appointmentHistory as $appointment)
                    <tr>
                        <td>{{ $appointment->service->name ?? 'N/A' }}</td>
                        <td>{{ $appointment->date->format('M d, Y') }}</td>
                        <td>{{ $appointment->event_type }}</td>
                        <td>
                            <span class="badge bg-{{ $appointment->status === 'completed' ? 'success' : ($appointment->status === 'cancelled' ? 'secondary' : 'warning') }}">
                                {{ ucfirst($appointment->status) }}
                            </span>
                        </td>
                        <td>
                            @if($appointment->status === 'completed')
                                @if($appointment->review)
                                    <span class="text-success"><i class="bi bi-check-circle"></i> Reviewed</span>
                                @else
                                    <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#reviewModal{{ $appointment->id }}">
                                        <i class="bi bi-star"></i> Leave Review
                                    </button>
                                    
                                    <!-- Review Modal -->
                                    <div class="modal fade" id="reviewModal{{ $appointment->id }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form action="{{ route('review.submit', $appointment) }}" method="POST">
                                                    @csrf
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Review {{ $appointment->service->name }}</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label class="form-label">Rating</label>
                                                            <select name="rating" class="form-select" required>
                                                                <option value="">Select rating...</option>
                                                                <option value="5">★★★★★ (5)</option>
                                                                <option value="4">★★★★☆ (4)</option>
                                                                <option value="3">★★★☆☆ (3)</option>
                                                                <option value="2">★★☆☆☆ (2)</option>
                                                                <option value="1">★☆☆☆☆ (1)</option>
                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Your Review</label>
                                                            <textarea name="content" class="form-control" rows="4" placeholder="Share your experience..." required></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-dark">Submit Review</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="bg-light p-4 rounded text-center">
            <p class="text-secondary mb-0">No appointment history yet.</p>
        </div>
    @endif
</section>
    
    <!-- Leave Review Section -->
    <section class="bg-light p-4 rounded">
        <h3 class="h5 fw-bold mb-3">Share Your Experience</h3>
        <p class="text-secondary mb-3">
            Loved our service? Leave a review from your appointment history above. 
            Your feedback helps us improve and helps others find us!
        </p>
    </section>
</div>
@endsection