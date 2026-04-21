@extends('layouts.app')

@section('title', 'My Bookings')

@section('content')
<div class="container py-5">
    <h1 class="mb-4">My Bookings</h1>
    
    @if($bookings->count() > 0)
        <div class="row">
            @foreach($bookings as $booking)
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5>{{ $booking->service->name }}</h5>
                        <p><strong>Date:</strong> {{ $booking->date->format('d M Y') }}</p>
                        <p><strong>Event:</strong> {{ $booking->event_type }}</p>
                        <p><strong>Status:</strong> 
                            <span class="badge bg-{{ $booking->status === 'pending' ? 'warning' : 'success' }}">
                                {{ ucfirst($booking->status) }}
                            </span>
                        </p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @else
        <p>No bookings yet. <a href="{{ route('booking.create') }}">Book your first appointment!</a></p>
    @endif
</div>
@endsection