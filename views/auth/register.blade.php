@extends('layouts.guest')

@section('content')
    <div>
        <h2 class="h3 mb-3 fw-bold">Sign up now!</h2>
        <p class="text-secondary mb-4">Create your account to book appointments and save your favorite looks.</p>
        
        <form method="POST" action="{{ route('register') }}">
            @csrf
            
            <!-- Name -->
            <div class="mb-3">
                <label for="name" class="form-label fw-medium">Full Name</label>
                <input id="name" type="text" 
                       class="form-control form-control-lg @error('name') is-invalid @enderror" 
                       name="name" value="{{ old('name') }}" required autofocus>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <!-- Email -->
            <div class="mb-3">
                <label for="email" class="form-label fw-medium">Email</label>
                <input id="email" type="email" 
                       class="form-control form-control-lg @error('email') is-invalid @enderror" 
                       name="email" value="{{ old('email') }}" required>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <!-- Phone -->
            <div class="mb-3">
                <label for="phone" class="form-label fw-medium">Phone (Optional)</label>
                <input id="phone" type="text" 
                       class="form-control form-control-lg @error('phone') is-invalid @enderror" 
                       name="phone" value="{{ old('phone') }}">
                @error('phone')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <!-- Password -->
            <div class="mb-3">
                <label for="password" class="form-label fw-medium">Password</label>
                <input id="password" type="password" 
                       class="form-control form-control-lg @error('password') is-invalid @enderror" 
                       name="password" required>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <!-- Confirm Password -->
            <div class="mb-4">
                <label for="password_confirmation" class="form-label fw-medium">Confirm Password</label>
                <input id="password_confirmation" type="password" 
                       class="form-control form-control-lg" 
                       name="password_confirmation" required>
            </div>
            
            <!-- Terms -->
            <div class="mb-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="terms" required>
                    <label class="form-check-label text-secondary" for="terms">
                        By signing up, you agree to our 
                        <a href="#" class="text-decoration-none">Terms of Service</a> and 
                        <a href="#" class="text-decoration-none">Privacy Policy</a>.
                    </label>
                </div>
            </div>
            
            <!-- Submit -->
            <button type="submit" class="btn btn-dark btn-lg w-100 mb-3">
                Sign up
            </button>
            
            <!-- Login Link -->
            <p class="text-center text-secondary">
                Already have an account? 
                <a href="{{ route('login') }}" class="text-decoration-none fw-medium">Log in</a>
            </p>
        </form>
    </div>
@endsection