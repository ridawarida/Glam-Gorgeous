@extends('layouts.app')

@section('title', 'Book Appointment')

@push('styles')
<style>
    .booking-form-card {
        border: none;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        border-radius: 12px;
    }
    .booking-form-card .card-header {
        background: transparent;
        border-bottom: 1px solid #eee;
        padding: 1.5rem 1.5rem 1rem;
    }
    .booking-form-card .card-body {
        padding: 1.5rem;
    }
</style>
@endpush

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="card booking-form-card">
                <div class="card-header">
                    <h2 class="h4 fw-bold mb-1">Book Your Appointment</h2>
                    <p class="text-secondary mb-0">Fill in the details below to request a booking.</p>
                </div>
                <div class="card-body">
                    <form action="{{ route('booking.store') }}" method="POST">
                        @csrf
                        
                        <!-- Service Selection -->
                        <div class="mb-4">
                            <label for="service_id" class="form-label fw-medium">Select Service *</label>
                            <select name="service_id" id="service_id" class="form-select @error('service_id') is-invalid @enderror" required>
                                <option value="">Choose a service...</option>
                                @foreach($services as $service)
                                    <option value="{{ $service->id }}" {{ old('service_id') == $service->id ? 'selected' : '' }}>
                                        {{ $service->name }} — ${{ number_format($service->price, 2) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('service_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Event Type -->
                        <div class="mb-4">
                            <label for="event_type" class="form-label fw-medium">Event Type *</label>
                            <select name="event_type" id="event_type" class="form-select @error('event_type') is-invalid @enderror" required>
                                <option value="">Select event type...</option>
                                <option value="Wedding" {{ old('event_type') == 'Wedding' ? 'selected' : '' }}>Wedding</option>
                                <option value="Photoshoot" {{ old('event_type') == 'Photoshoot' ? 'selected' : '' }}>Photoshoot</option>
                                <option value="Birthday" {{ old('event_type') == 'Birthday' ? 'selected' : '' }}>Birthday</option>
                                <option value="Graduation" {{ old('event_type') == 'Graduation' ? 'selected' : '' }}>Graduation</option>
                                <option value="Prom/Formal" {{ old('event_type') == 'Prom/Formal' ? 'selected' : '' }}>Prom/Formal</option>
                                <option value="Other" {{ old('event_type') == 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('event_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Date -->
                        <div class="mb-4">
                            <label for="date" class="form-label fw-medium">Preferred Date *</label>
                            <input type="date" 
                                   name="date" 
                                   id="date" 
                                   class="form-control @error('date') is-invalid @enderror" 
                                   value="{{ old('date') }}"
                                   min="{{ date('Y-m-d', strtotime('+2 days')) }}"
                                   required>
                            <small class="text-secondary">Please allow at least 2 days notice.</small>
                            @error('date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Location -->
                        <div class="mb-4">
                            <label for="location" class="form-label fw-medium">Location *</label>
                            <input type="text" 
                                   name="location" 
                                   id="location" 
                                   class="form-control @error('location') is-invalid @enderror" 
                                   value="{{ old('location') }}"
                                   placeholder="e.g., Studio address or 'On-location - Sydney CBD'"
                                   required>
                            @error('location')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Special Instructions -->
                        <div class="mb-4">
                            <label for="instruction" class="form-label fw-medium">Special Instructions (Optional)</label>
                            <textarea name="instruction" 
                                      id="instruction" 
                                      class="form-control" 
                                      rows="3"
                                      placeholder="Any specific requests, allergies, or notes...">{{ old('instruction') }}</textarea>
                        </div>
                        
                        <!-- Submit -->
                        <div class="d-grid">
                            <button type="submit" class="btn btn-dark btn-lg">
                                Submit Booking Request
                            </button>
                        </div>
                        
                        <p class="text-secondary small text-center mt-3 mb-0">
                            <i class="bi bi-info-circle"></i> 
                            Your booking will be reviewed and confirmed via email.
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
 <!-- FAQ Section -->
            <div class="faq-section">
                <h3 class="h5 fw-bold mb-4">Frequently Asked Questions</h3>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <i class="bi bi-question-circle text-secondary me-2"></i>
                        How far in advance should I book?
                    </div>
                    <p class="faq-answer ms-4">
                        We recommend booking at least 2-4 weeks in advance for regular appointments, 
                        and 2-3 months for weddings or large events.
                    </p>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <i class="bi bi-question-circle text-secondary me-2"></i>
                        What if I need to cancel or reschedule?
                    </div>
                    <p class="faq-answer ms-4">
                        Cancellations made at least 48 hours before your appointment will receive a full refund. 
                        You can cancel pending bookings from your dashboard.
                    </p>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <i class="bi bi-question-circle text-secondary me-2"></i>
                        Do you travel for on-location services?
                    </div>
                    <p class="faq-answer ms-4">
                        Yes! We serve Sydney, Melbourne, and surrounding areas. Travel fees may apply 
                        for locations outside a 20km radius of the CBD.
                    </p>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <i class="bi bi-question-circle text-secondary me-2"></i>
                        What products do you use?
                    </div>
                    <p class="faq-answer ms-4">
                        We use premium, long-lasting products from brands like MAC, NARS, Charlotte Tilbury, 
                        and other professional-grade cosmetics. All products are cruelty-free.
                    </p>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <i class="bi bi-question-circle text-secondary me-2"></i>
                        Can I request a trial run?
                    </div>
                    <p class="faq-answer ms-4">
                        Absolutely! Trial runs are recommended for bridal and special event bookings. 
                        Select "Bridal Package" and mention "trial requested" in the special instructions.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection