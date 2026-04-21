@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container-fluid py-4">
    <!-- Welcome -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h1 class="h3 fw-bold mb-3">Welcome, dear stylist!</h1>
                    <p class="text-secondary mb-4">{{ $welcome_message }}</p>
                    <div class="d-flex flex-wrap gap-2">
                        <a href="{{ route('admin.content.edit') }}" class="btn btn-dark">
                            <i class="bi bi-pencil"></i> Edit Home Page
                        </a>
                        <a href="{{ route('services') }}" class="btn btn-outline-dark"><i class="bi bi-list"></i> View Services Page</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Overview-->
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="h4 fw-bold mb-3">Overview</h2>
        </div>
        
        <!-- Popular Services -->
        <div class="col-md-4 mb-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title fw-bold">Popular services</h5>
                    @if($stats['popular_services']->count() > 0)
                        <ul class="list-unstyled mb-0">
                            @foreach($stats['popular_services'] as $service)
                            <li class="mb-2">
                                <strong>{{ $service->name }}</strong>
                                <span class="text-secondary">({{ $service->appointments_count }} bookings)</span>
                            </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-secondary mb-0">No bookings yet.</p>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Monthly Bookings -->
        <div class="col-md-4 mb-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title fw-bold">Monthly bookings</h5>
                    <h2 class="display-4 fw-bold">{{ $stats['monthly_bookings'] }}</h2>
                    <p class="text-secondary">Bookings this month</p>
                </div>
            </div>
        </div>
        
        <!-- Total Customers -->
        <div class="col-md-4 mb-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title fw-bold">Customers</h5>
                    <h2 class="display-4 fw-bold">{{ $stats['total_customers'] }}</h2>
                    <p class="text-secondary">Registered clients</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- List of Appointments (Active) -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white fw-bold py-3">
                    Active Appointments
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Customer</th>
                                    <th>Service</th>
                                    <th>Event</th>
                                    <th>Location</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($appointments as $appointment)
                                <tr>
                                    <td>#{{ $appointment->id }}</td>
                                    <td>{{ $appointment->client->name ?? 'N/A' }}</td>
                                    <td>{{ $appointment->service->name ?? 'N/A' }}</td>
                                    <td>{{ $appointment->event_type }}</td>
                                    <td>{{ Str::limit($appointment->location, 20) }}</td>
                                    <td>{{ \Carbon\Carbon::parse($appointment->date)->format('d/m/Y') }}</td>
                                    <td>
                                        <span class="badge bg-{{ $appointment->status === 'confirmed' ? 'success' : 'warning' }}">
                                            {{ ucfirst($appointment->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                Action
                                            </button>
                                            <ul class="dropdown-menu">
                                                @if($appointment->status === 'pending')
                                                <li>
                                                    <form action="{{ route('admin.appointments.status', $appointment) }}" method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="confirmed">
                                                        <button type="submit" class="dropdown-item text-success">
                                                            <i class="bi bi-check-circle"></i> Confirm
                                                        </button>
                                                    </form>
                                                </li>
                                                @endif
                                                
                                                @if($appointment->status === 'confirmed')
                                                <li>
                                                    <form action="{{ route('admin.appointments.status', $appointment) }}" method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="completed">
                                                        <button type="submit" class="dropdown-item text-primary">
                                                            <i class="bi bi-check-all"></i> Mark Complete
                                                        </button>
                                                    </form>
                                                </li>
                                                @endif
                                                
                                                @if(in_array($appointment->status, ['pending', 'confirmed']))
                                                <li><hr class="dropdown-divider"></li>
                                                <li>
                                                    <form action="{{ route('admin.appointments.status', $appointment) }}" method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="cancelled">
                                                        <button type="submit" class="dropdown-item text-danger">
                                                            <i class="bi bi-x-circle"></i> Cancel
                                                        </button>
                                                    </form>
                                                </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center py-4 text-secondary">
                                        No active appointments.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Appointment History -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white fw-bold py-3">
                    Appointment History
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Customer</th>
                                    <th>Service</th>
                                    <th>Event</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Review</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($appointmentHistory as $history)
                                <tr>
                                    <td>#{{ $history->id }}</td>
                                    <td>{{ $history->client->name ?? 'N/A' }}</td>
                                    <td>{{ $history->service->name ?? 'N/A' }}</td>
                                    <td>{{ $history->event_type }}</td>
                                    <td>{{ \Carbon\Carbon::parse($history->date)->format('d/m/Y') }}</td>
                                    <td>
                                        <span class="badge bg-{{ $history->status === 'completed' ? 'success' : 'secondary' }}">
                                            {{ ucfirst($history->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($history->review)
                                            <span class="text-warning">
                                                @for($i = 1; $i <= 5; $i++)
                                                    @if($i <= $history->review->rating)
                                                        <i class="bi bi-star-fill"></i>
                                                    @else
                                                        <i class="bi bi-star"></i>
                                                    @endif
                                                @endfor
                                            </span>
                                            <br>
                                            <small class="text-secondary">{{ Str::limit($history->review->content, 30) }}</small>
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4 text-secondary">
                                        No appointment history.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
        
    <!-- List of Reviews -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white fw-bold py-3">
                    List of reviews
                </div>
                <div class="card-body">
                    @forelse($reviews as $review)
                    <div class="review-item pb-4 {{ !$loop->last ? 'border-bottom mb-4' : '' }}">
                        <div class="d-flex align-items-center mb-2">
                            <div>
                                <strong>{{ $review->user->name ?? 'Anonymous' }}</strong>
                                <span class="text-secondary ms-2">({{ $review->created_at->format('d/m/Y') }})</span>
                            </div>
                            <div class="ms-3">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $review->rating)
                                        <i class="bi bi-star-fill text-warning small"></i>
                                    @else
                                        <i class="bi bi-star text-warning small"></i>
                                    @endif
                                @endfor
                            </div>
                            @if($review->featured)
                            <span class="badge bg-success ms-2">Featured</span>
                            @endif
                        </div>
                        <p class="text-secondary mb-2">{{ $review->content }}</p>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.reviews.toggle', $review) }}" 
                               onclick="event.preventDefault(); document.getElementById('toggle-{{ $review->id }}').submit();"
                               class="text-decoration-none small">
                                {{ $review->featured ? 'Remove from Homepage' : 'Feature on Homepage' }}
                            </a>
                            <form id="toggle-{{ $review->id }}" action="{{ route('admin.reviews.toggle', $review) }}" method="POST" style="display: none;">
                                @csrf
                                @method('PATCH')
                            </form>
                        </div>
                    </div>
                    @empty
                    <p class="text-secondary mb-0">No reviews yet.</p>
                    @endforelse
                    
                    @if($reviews->count() > 0)
                    <div class="mt-3">
                        <a href="{{ route('admin.reviews.index') }}" class="btn btn-sm btn-outline-dark">
                            View All Reviews
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection