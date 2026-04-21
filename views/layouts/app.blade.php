<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name', 'Makeup Studio'))</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        .min-vh-80 { min-height: 80vh; }
        
        .navbar {
            background-color: white;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }
        
        .navbar-nav {
            margin-left: auto;
            align-items: center;
        }
        
        .navbar-nav .nav-link {
            color: #1a1a1a;
            padding: 10px 15px;
        }
        
        .navbar-nav .nav-link:hover {
            color: #000000;
        }
        
        .navbar-nav .btn {
            color: #ffffff;
            background-color: #1a1a1a;
            border-color: #1a1a1a;
            margin-left: 10px;
        }
        
        .navbar-nav .btn:hover {
            background-color: #000000;
            color: white;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm py-3">
        <div class="container">
            <a class="navbar-brand fw-bold fs-4 d-flex align-items-center" href="{{ route('home') }}">
                <img src="{{ asset('images/Home icon.png') }}" alt="Home" class="me-2" style="height: 32px; width: auto;">
                Glam&Gorgeous
            </a>
            
            <div class="d-flex">
                <ul class="navbar-nav flex-row">
                    @auth
                        @if(Auth::user()->role === 'admin')
                            {{-- Admin Navigation --}}
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('home') }}">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.dashboard') }}">
                                    Admin Dashboard
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.portfolio.index') }}">
                                    Manage Portfolio
                                </a>
                            </li>
                            <li class="nav-item">
                                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-dark btn-sm ms-2">
                                        <i class="bi bi-box-arrow-right"></i> Logout
                                    </button>
                                </form>
                            </li>
                        @else
                            {{-- Client Navigation --}}
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('home') }}">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('portfolio') }}">Portfolio</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('services') }}">Services</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('dashboard') }}">My Dashboard</a>
                            </li>
                            <li class="nav-item">
                                <a class="btn btn-dark ms-2" href="{{ route('booking.create') }}">Book Now</a>
                            </li>
                            <li class="nav-item">
                                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-dark btn-sm ms-2">
                                        <i class="bi bi-box-arrow-right"></i> Logout
                                    </button>
                                </form>
                            </li>
                        @endif
                    @else
                        {{-- Guest Navigation --}}
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('home') }}">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('portfolio') }}">Portfolio</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('services') }}">Services</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-dark ms-2" href="{{ route('register') }}">Sign Up</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>
    
    <main>
        @yield('content')
    </main>
    
    <footer class="bg-dark text-white py-5 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5>{{ config('app.name') }}</h5>
                    <p class="text-secondary">{!! nl2br(e(\App\Models\Content::getValue('home_address', '123 Main Street'))) !!}</p>
                </div>
                <div class="col-md-4">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('portfolio') }}" class="text-secondary text-decoration-none">Portfolio</a></li>
                        <li><a href="{{ route('services') }}" class="text-secondary text-decoration-none">Services</a></li>
                        @auth
                            @if(Auth::user()->role === 'client')
                                <li><a href="{{ route('booking.create') }}" class="text-secondary text-decoration-none">Book Now</a></li>
                            @endif
                        @else
                            <li><a href="{{ route('booking.create') }}" class="text-secondary text-decoration-none">Book Now</a></li>
                        @endauth
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5>Contact</h5>
                    <p class="text-secondary">
                        <i class="bi bi-envelope"></i> hello@makeupstudio.com<br>
                        <i class="bi bi-telephone"></i> +61 400 000 000
                    </p>
                </div>
            </div>
            <hr class="my-4 border-secondary">
            <p class="text-center text-secondary mb-0">
                &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
            </p>
        </div>
    </footer>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>