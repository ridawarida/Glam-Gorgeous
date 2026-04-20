@extends('layouts.app')

@section('title', 'Manage Reviews')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Manage Reviews</h1>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">Back to Dashboard</a>
    </div>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Client</th>
                            <th>Rating</th>
                            <th>Review</th>
                            <th>Date</th>
                            <th>Featured</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reviews as $review)
                        <tr>
                            <td>{{ $review->user->name ?? 'Anonymous' }}</td>
                            <td>
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $review->rating)
                                        <i class="bi bi-star-fill text-warning small"></i>
                                    @else
                                        <i class="bi bi-star text-warning small"></i>
                                    @endif
                                @endfor
                            </td>
                            <td>{{ Str::limit($review->content, 50) }}</td>
                            <td>{{ $review->created_at->format('d M Y') }}</td>
                            <td>
                                @if($review->featured)
                                    <span class="badge bg-success">Featured</span>
                                @else
                                    <span class="badge bg-secondary">Hidden</span>
                                @endif
                            </td>
                            <td>
                                <form action="{{ route('admin.reviews.toggle', $review) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-sm {{ $review->featured ? 'btn-outline-danger' : 'btn-outline-success' }}">
                                        {{ $review->featured ? 'Remove from Homepage' : 'Feature on Homepage' }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            {{ $reviews->links() }}
        </div>
    </div>
</div>
@endsection