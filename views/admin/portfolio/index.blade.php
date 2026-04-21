@extends('layouts.app')

@section('title', 'Manage Portfolio')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Manage Portfolio</h1>
        <div>
            <a href="{{ route('admin.portfolio.create') }}" class="btn btn-dark">
                <i class="bi bi-plus-circle"></i> Upload New Image
            </a>
        </div>
    </div>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    
    <div class="card mb-4">
        <div class="card-header fw-bold">Link Before/After Pair</div>
        <div class="card-body">
            <form action="{{ route('admin.portfolio.link-pair') }}" method="POST" class="row g-3">
                @csrf
                <div class="col-md-5">
                    <label class="form-label">Before Image</label>
                    <select name="before_id" class="form-select" required>
                        <option value="">Select before image...</option>
                        @foreach(\App\Models\Portfolio::all() as $img)
                            <option value="{{ $img->id }}">#{{ $img->id }} - {{ Str::limit($img->alt_text, 30) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-5">
                    <label class="form-label">After Image</label>
                    <select name="after_id" class="form-select" required>
                        <option value="">Select after image...</option>
                        @foreach(\App\Models\Portfolio::all() as $img)
                            <option value="{{ $img->id }}">#{{ $img->id }} - {{ Str::limit($img->alt_text, 30) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">Link Pair</button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Portfolio Grid -->
    <div class="row g-4">
        @foreach($portfolio as $item)
        <div class="col-md-3">
            <div class="card h-100">
                <img src="{{ $item->image_url }}" class="card-img-top" style="height: 200px; object-fit: cover;" alt="{{ $item->alt_text }}">
                <div class="card-body">
                    <p class="small mb-2">{{ Str::limit($item->alt_text, 40) }}</p>
                    <span class="badge bg-secondary">{{ $item->category->name ?? 'Uncategorized' }}</span>
                    
                    @if($item->is_before)
                        <span class="badge bg-warning">Before</span>
                        @if($item->after_image_id)
                            <span class="badge bg-success">Linked #{{ $item->after_image_id }}</span>
                        @endif
                    @endif
                </div>
                <div class="card-footer bg-white border-top-0">
                    <form action="{{ route('admin.portfolio.destroy', $item) }}" method="POST" onsubmit="return confirm('Delete this image?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger w-100">
                            <i class="bi bi-trash"></i> Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    
    {{ $portfolio->links() }}
</div>
@endsection