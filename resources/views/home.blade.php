@extends('layouts.app')

@section('title', 'Home')

@section('content')
<!-- Hero Section -->
<section class="hero-section" style="background: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4)), url('https://images.squarespace-cdn.com/content/v1/62324437e2383764126b2994/5a762b6d-3461-4bb8-a8e8-b48dbc0e4fd6/Photo+Dec+08%2C+11+01+11+PM.jpg') center/cover no-repeat; min-height: 80vh;">
    <div class="container h-100">
        <div class="row align-items-center" style="min-height: 80vh;">
            <div class="col-lg-8 text-white">
                <h1 class="display-3 fw-bold mb-4">{{ $data['hero_title'] }}</h1>
                <p class="lead mb-4">{{ $data['hero_subtitle'] }}</p>
                @if(!Auth::check() || !Auth::user()->isAdmin())
                <a href="{{ url($data['hero_button_url']) }}" class="btn btn-light btn-lg px-5">
                    {{ $data['hero_button_text'] }}
                </a>
                @endif
            </div>
        </div>
    </div>
</section>

<!-- Reviews Section -->
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold">{{ $data['reviews_title'] ?? 'What Our Clients Say' }}</h2>
            <p class="text-secondary">{{ $data['reviews_subtitle'] ?? 'Real reviews from real clients' }}</p>
        </div>
        
        <div class="row g-4">
            @forelse($reviews ?? [] as $review)
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body p-4">
                        <div class="mb-3">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $review->rating)
                                    <i class="bi bi-star-fill text-warning"></i>
                                @else
                                    <i class="bi bi-star text-warning"></i>
                                @endif
                            @endfor
                        </div>
                        <p class="card-text mb-4">"{{ $review->content }}"</p>
                        <p class="fw-bold mb-0">
                            — {{ $review->user->name ?? 'Verified Client' }}
                        </p>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center">
                <p class="text-secondary">No reviews yet. Be the first to leave a review!</p>
            </div>
            @endforelse
        </div>
    </div>
</section>

<!-- About Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <span class="text-uppercase text-muted small fw-bold tracking-wider">{{ $data['about_title'] }}</span>
                <p class="lead text-secondary mt-4">{{ $data['about_text'] }}</p>
            </div>
            <div class="col-lg-6">
                <img src="{{ asset('images/Screenshot 2026-04-20 221922.png') }}" 
                     alt="About Us" 
                     class="img-fluid rounded shadow">
            </div>
        </div>
    </div>
</section>

<!-- Contact Section -->
@if(!Auth::check() || !Auth::user()->isAdmin())
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 mx-auto text-center">
                <h2 class="fw-bold mb-3">{{ $data['contact_title'] }}</h2>
                <p class="text-secondary mb-4">{{ $data['contact_subtitle'] }}</p>
                
                <form action="#" method="POST" class="text-start">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <input type="text" name="name" class="form-control" placeholder="Your Name" required>
                        </div>
                        <div class="col-md-6">
                            <input type="email" name="email" class="form-control" placeholder="Your Email" required>
                        </div>
                        <div class="col-12">
                            <textarea name="message" class="form-control" rows="4" placeholder="Your Message" required></textarea>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-dark w-100">
                                {{ $data['contact_button_text'] }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endif

@endsection