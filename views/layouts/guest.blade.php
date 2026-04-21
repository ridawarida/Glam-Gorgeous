<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Makeup & Hair') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=antic-didone:400" rel="stylesheet" />
        <!-- Scripts -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            .navbar {
                background-color: white;
                box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            }
            
            .navbar-toggler {
                border: 2px solid #1a1a1a;
                padding: 0.25rem 0.75rem;
            }
            
            .navbar-toggler:focus {
                box-shadow: 0 0 0 0.25rem rgba(26, 26, 26, 0.25);
            }
            
            .navbar-toggler-icon {
                background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='%231a1a1a' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
                background-size: 100%;
            }
            
            .navbar-nav {
                display: none;
            }
            
            .navbar-nav.show {
                display: block;
            }
            
            .navbar-nav .nav-item {
                padding: 8px 0;
            }
            
            .navbar-nav .nav-link {
                color: #1a1a1a;
                padding: 8px 15px;
                display: block;
            }
            
            .navbar-nav .nav-link:hover {
                background-color: #e9ecef;
                border-radius: 4px;
            }
            
            @media (min-width: 992px) {
                .navbar-nav {
                    display: flex !important;
                    margin-left: auto;
                    align-items: center;
                }
                
                .navbar-toggler {
                    display: none;
                }
            }
            
            .benefits-section {
                position: relative;
                background-color: #f8f9fa; 
                overflow: hidden;
            }
            
            .benefits-section::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background-image: url('https://static.vecteezy.com/system/resources/thumbnails/055/700/126/small_2x/beautiful-black-model-posing-with-vivid-red-and-silver-eyeshadow-makeup-photo.jpg');
                background-size: cover;
                background-position: center;
                opacity: 0.7;
                z-index: 0;
            }
            
            .benefits-content {
                position: relative;
                z-index: 1;
            }
        </style>
    </head>
    <body class="font-sans antialiased">
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm py-3">
            <div class="container">
                <a class="navbar-brand fw-bold fs-4 d-flex align-items-center" href="{{ route('home') }}">
                    <img src="{{ asset('images/Home icon.png') }}" alt="Home" class="me-2" style="height: 32px; width: auto;">
                    Glam&Gorgeous
                </a>
                <button class="navbar-toggler" type="button" id="navbarToggler">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div id="navbarNav">
                    <ul class="navbar-nav ms-auto">
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
                            <a class="nav-link" href="{{ route('booking.create') }}">Book Now</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <div class="min-vh-100 d-flex">
        <!-- Left Column - Form -->
        <div class="col-lg-6 d-flex align-items-center justify-content-center p-5 bg-white">
            <div class="w-100" style="max-width: 450px;">
                <div class="text-center mb-4">
                    <h1 class="display-4 fw-bold">Glam&Gorgeous</h1>
                </div>
                
                @yield('content')
            </div>
        </div>
        
        <!-- Right Column - Benefits  -->
        <div class="col-lg-6 d-none d-lg-flex flex-column justify-content-center p-5 benefits-section">
            <div class="w-100 benefits-content" style="max-width: 500px; margin: 0 auto;">
                <h2 class="display-5 fw-bold mb-5 text-dark">Why Have An Account?</h2>
                
                <div class="mb-5">
                    <h3 class="h4 fw-bold"> Book Your Appointments Online!</h3>
                    <p class="text-light">Our certified makeup artists bring years of experience in bridal, editorial, and special event styling.</p>
                </div>
                
                <div class="mb-5">
                    <h3 class="h4 fw-bold">Find Inspiration from Our Curated Portfolio!</h3>
                    <p class="text-light">Browse through our collection of stunning makeup looks and get inspired for your next event.</p>
                </div>
                
                <div class="mb-5">
                    <h3 class="h4 fw-bold">Get Exclusive Offers!</h3>
                    <p class="text-light">Sign up for our newsletter and be the first to know about special promotions and new services.</p>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggler = document.getElementById('navbarToggler');
            const navbarNav = document.getElementById('navbarNav');
            const navList = navbarNav.querySelector('.navbar-nav');
            
            if (toggler && navList) {
                toggler.addEventListener('click', function(e) {
                    e.preventDefault();
                    navList.classList.toggle('show');
                });
                
                const links = navList.querySelectorAll('a, button');
                links.forEach(link => {
                    link.addEventListener('click', function() {
                        navList.classList.remove('show');
                    });
                });
            }
        });
    </script>
</body>
</html>