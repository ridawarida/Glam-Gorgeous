@extends('layouts.app')

@section('title', 'Portfolio')

@push('styles')
<style>
.before-after-card {
    cursor: pointer;
    transition: transform 0.2s;
}
.before-after-card:hover {
    transform: scale(1.02);
}
.favorite-btn {
    position: absolute;
    top: 10px;
    right: 10px;
    z-index: 10;
    background: white;
    border: none;
    border-radius: 50%;
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    transition: all 0.2s;
    cursor: pointer;
}
.favorite-btn:hover {
    transform: scale(1.1);
    background: white;
}
.favorite-btn .bi-heart-fill {
    color: #dc3545;
}
.gallery-image {
    height: 280px;
    object-fit: cover;
    width: 100%;
}
.transformation-image {
    height: 280px;
    object-fit: cover;
    width: 100%;
}

.portfolio-card {
    height: 400px;
    display: flex;
    flex-direction: column;
}

.portfolio-card .card-body {
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    min-height: 120px;
}
</style>
@endpush

@section('content')
<div class="container py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h2 fw-bold">Our Gallery</h1>
        
        @auth
            @if(Auth::user()->role === 'admin')
            <a href="{{ route('admin.portfolio.index') }}" class="btn btn-outline-dark">
                <i class="bi bi-images"></i> Manage Portfolio
            </a>
            @endif
        @endauth
    </div>
    
    <!-- Favorites Section (Clients Only) -->
    @auth
        @if(Auth::user()->role === 'client' && $favorites->count() > 0)
        <section class="mb-5">
            <h2 class="h4 fw-bold mb-3">
                <i class="bi bi-heart-fill text-danger"></i> Your Favorites
            </h2>
            <div class="row g-4">
                @foreach($favorites->take(4) as $item)
                <div class="col-md-3 col-6">
                    <div class="card portfolio-card position-relative">
                        <img src="{{ $item->image_url }}" 
                             class="card-img-top gallery-image" 
                             alt="{{ $item->alt_text }}">
                        <div class="card-body p-2">
                            <p class="small text-secondary mb-0">{{ Str::limit($item->alt_text, 30) }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @if($favorites->count() > 4)
            <div class="text-end mt-2">
                <a href="#" class="text-decoration-none" onclick="alert('View all favorites coming soon!')">
                    View all ({{ $favorites->count() }}) <i class="bi bi-arrow-right"></i>
                </a>
            </div>
            @endif
        </section>
        @endif
    @endauth
    
    <!-- Transformations (Before/After) -->
    @if($beforeAfterPairs->count() > 0)
    <section class="mb-5">
        <h2 class="h4 fw-bold mb-3"> Transformations</h2>
        <p class="text-secondary mb-4">Click on any image to see the before and after</p>
        
        <div class="row g-4">
            @foreach($beforeAfterPairs as $before)
            <div class="col-md-4 col-6">
                <div class="card portfolio-card before-after-card border-0 shadow-sm" 
                     data-before="{{ $before->image_url }}"
                     data-after="{{ $before->afterImage->image_url ?? $before->image_url }}"
                     data-showing="before"
                     onclick="toggleBeforeAfter(this)">
                    <div class="position-relative h-100">
                        <img src="{{ $before->image_url }}" 
                             class="card-img-top transformation-image" 
                             alt="{{ $before->alt_text }}">
                        
                        <!-- Label Overlay -->
                        <div class="position-absolute bottom-0 start-0 end-0 text-white p-3" 
                             style="background: linear-gradient(transparent, rgba(0,0,0,0.7));">
                            <div class="d-flex justify-content-between align-items-end">
                                <div>
                                    <span class="badge bg-light text-dark mb-2 before-label">BEFORE</span>
                                    <span class="badge bg-light text-dark mb-2 after-label d-none">AFTER</span>
                                    <p class="mb-0 fw-medium">{{ Str::limit($before->alt_text, 40) }}</p>
                                </div>
                                <small><i class="bi bi-arrow-repeat"></i> Click</small>
                            </div>
                        </div>
                        
                        @if($before->category)
                        <span class="position-absolute top-0 start-0 badge bg-dark bg-opacity-75 text-white m-2">
                            {{ $before->category->name }}
                        </span>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>
    @endif
    
    <!-- Full Gallery -->
    <section>
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="h4 fw-bold mb-0">Full Gallery</h2>
            
            <!-- Category Filter -->
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('portfolio') }}" 
                   class="btn btn-sm {{ !request('category') ? 'btn-dark' : 'btn-outline-dark' }}">
                    All
                </a>
                @foreach($categories as $category)
                <a href="{{ route('portfolio', ['category' => $category->id]) }}" 
                   class="btn btn-sm {{ request('category') == $category->id ? 'btn-dark' : 'btn-outline-dark' }}">
                    {{ $category->name }}
                </a>
                @endforeach
            </div>
        </div>
        
        <div class="row g-4">
            @forelse($gallery as $item)
            <div class="col-md-3 col-6">
                <div class="card portfolio-card position-relative border-0 shadow-sm">
                    <!-- Favorite Button (Clients Only) -->
                    @auth
                        @if(Auth::user()->role === 'client')
                        <button class="favorite-btn" 
                                data-portfolio-id="{{ $item->id }}"
                                onclick="toggleFavorite(event, this)"
                                type="button">
                            <i class="bi {{ $item->isFavouritedBy(Auth::user()) ? 'bi-heart-fill text-danger' : 'bi-heart' }}"></i>
                        </button>
                        @endif
                    @endauth
                    
                    <img src="{{ $item->image_url }}" 
                         class="card-img-top gallery-image" 
                         alt="{{ $item->alt_text }}"
                         loading="lazy">
                    <div class="card-body p-3">
                        <p class="small text-secondary mb-2">{{ Str::limit($item->alt_text, 40) }}</p>
                        <div>
                            @if($item->category)
                            <span class="badge bg-secondary">{{ $item->category->name }}</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <i class="bi bi-images display-1 text-secondary"></i>
                <p class="text-secondary mt-3">No images in this category yet.</p>
            </div>
            @endforelse
        </div>
        
        <!-- Pagination -->
        @if($gallery->hasPages())
        <div class="mt-5">
            {{ $gallery->links() }}
        </div>
        @endif
    </section>
</div>

<script>
// Before/After Toggle
function toggleBeforeAfter(element) {
    const beforeUrl = element.dataset.before;
    const afterUrl = element.dataset.after;
    const img = element.querySelector('img');
    const beforeLabel = element.querySelector('.before-label');
    const afterLabel = element.querySelector('.after-label');
    
    if (element.dataset.showing === 'before') {
        img.src = afterUrl;
        beforeLabel.classList.add('d-none');
        afterLabel.classList.remove('d-none');
        element.dataset.showing = 'after';
    } else {
        img.src = beforeUrl;
        beforeLabel.classList.remove('d-none');
        afterLabel.classList.add('d-none');
        element.dataset.showing = 'before';
    }
}

// Favorite Toggle
async function toggleFavorite(event, button) {
    event.preventDefault();
    event.stopPropagation();
    
    const portfolioId = button.dataset.portfolioId;
    const icon = button.querySelector('i');
    
    try {
        const response = await fetch(`/portfolio/${portfolioId}/favorite`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        });
        
        if (!response.ok) {
            if (response.status === 401) {
                window.location.href = '/login';
                return;
            }
            throw new Error('Network response was not ok');
        }
        
        const data = await response.json();
        
        if (data.success) {
            if (data.favorited) {
                icon.classList.remove('bi-heart');
                icon.classList.add('bi-heart-fill', 'text-danger');
            } else {
                icon.classList.remove('bi-heart-fill', 'text-danger');
                icon.classList.add('bi-heart');
            }
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Something went wrong. Please try again.');
    }
}
</script>
@endsection