@extends('layouts.guest')

@section('content')
    <div>
        <h2 class="h3 mb-3 fw-bold">Welcome back!</h2>
        <p class="text-secondary mb-4">Sign in to manage your appointments and view your favorites.</p>
        
        <!-- Session Status -->
        @if (session('status'))
            <div class="alert alert-success mb-3">
                {{ session('status') }}
            </div>
        @endif
        
        <form method="POST" action="{{ route('login') }}">
            @csrf
            
            <!-- Email -->
            <div class="mb-3">
                <label for="email" class="form-label fw-medium">Email</label>
                <input id="email" type="email" 
                       class="form-control form-control-lg @error('email') is-invalid @enderror" 
                       name="email" value="{{ old('email') }}" required autofocus>
                @error('email')
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
            
            <!-- Remember Me -->
            <div class="mb-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                    <label class="form-check-label text-secondary" for="remember">
                        Remember me
                    </label>
                </div>
            </div>
            
            <!-- Submit -->
            <button type="submit" class="btn btn-dark btn-lg w-100 mb-3">
                Log In
            </button>
            
            <!-- Links -->
            <div class="d-flex justify-content-between">
                <a href="{{ route('register') }}" class="text-decoration-none">
                    Create account
                </a>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-decoration-none text-secondary">
                        Forgot password?
                    </a>
                @endif
            </div>
        </form>
    </div>
@endsection