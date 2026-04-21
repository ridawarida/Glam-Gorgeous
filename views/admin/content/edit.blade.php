@extends('layouts.app')

@section('title', 'Edit Homepage Content')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <h1 class="mb-4">Edit Homepage Content</h1>
            
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            
            <form method="POST" action="{{ route('admin.content.update') }}">
                @csrf
                @method('PUT')
                
                <div class="card mb-4">
                    <div class="card-header fw-bold">Hero Section</div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Hero Title</label>
                            <input type="text" name="home_hero_title" class="form-control" 
                                   value="{{ $contents['home_hero_title'] ?? '' }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Hero Subtitle</label>
                            <textarea name="home_hero_subtitle" class="form-control" rows="2">{{ $contents['home_hero_subtitle'] ?? '' }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Button Text</label>
                            <input type="text" name="home_hero_button" class="form-control" 
                                   value="{{ $contents['home_hero_button'] ?? 'Book Now' }}">
                        </div>
                    </div>
                </div>
                
                <div class="card mb-4">
                    <div class="card-header fw-bold">About Section</div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Title</label>
                            <input type="text" name="home_about_title" class="form-control" 
                                   value="{{ $contents['home_about_title'] ?? '' }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Text</label>
                            <textarea name="home_about_text" class="form-control" rows="4">{{ $contents['home_about_text'] ?? '' }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Button Text</label>
                            <input type="text" name="home_about_button" class="form-control" 
                                   value="{{ $contents['home_about_button'] ?? 'Learn More' }}">
                        </div>
                    </div>
                </div>
                
                <div class="card mb-4">
                    <div class="card-header fw-bold">Contact Section</div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Title</label>
                            <input type="text" name="home_contact_title" class="form-control" 
                                   value="{{ $contents['home_contact_title'] ?? '' }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Text</label>
                            <textarea name="home_contact_text" class="form-control" rows="3">{{ $contents['home_contact_text'] ?? '' }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Address</label>
                            <textarea name="home_address" class="form-control" rows="3">{{ $contents['home_address'] ?? '' }}</textarea>
                        </div>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-dark btn-lg">Save Changes</button>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary btn-lg ms-2">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection