@extends('layouts.app')

@section('title', 'Services')

@push('styles')
<style>
    .service-card {
        border: none;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        border-radius: 12px;
        transition: transform 0.2s, box-shadow 0.2s;
        height: 100%;
    }
    .service-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 30px rgba(0,0,0,0.1);
    }
    .service-icon {
        font-size: 2.5rem;
        margin-bottom: 1rem;
    }
    .price-tag {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1a1a1a;
    }
    .category-tag {
        position: absolute;
        top: 1rem;
        left: 1rem;
        z-index: 5;
    }
    .admin-edit-btn {
        position: absolute;
        top: 1rem;
        right: 1rem;
        z-index: 5;
        opacity: 0;
        transition: opacity 0.2s;
    }
    .service-card:hover .admin-edit-btn {
        opacity: 1;
    }
</style>
@endpush

@section('content')
<div class="container py-5">
    <!-- Header -->
    <div class="text-center mb-5">
        <h1 class="display-4 fw-bold mb-3">Our Services</h1>
        <p class="lead text-secondary mx-auto" style="max-width: 700px;">
            Professional hair and makeup services tailored to your unique style and occasion.
        </p>
    </div>
    
    <!-- Admin Controls -->
    @auth
        @if(Auth::user()->role === 'admin')
        <div class="text-end mb-4">
            <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#addServiceModal">
                <i class="bi bi-plus-circle"></i> Add New Service
            </button>
        </div>
        @endif
    @endauth
    
    <!-- Services Grid -->
    <div class="row g-4">
        @forelse($services as $service)
        <div class="col-md-6 col-lg-4">
            <div class="service-card position-relative p-4 bg-white">
                @if($service->category)
                <div class="category-tag">
                    <span class="badge bg-secondary">{{ $service->category->name }}</span>
                </div>
                @endif
                
                <!-- Admin Edit Button -->
                @auth
                    @if(Auth::user()->role === 'admin')
                    <div class="admin-edit-btn">
                        <button class="btn btn-light btn-sm rounded-circle shadow-sm" 
                                onclick="editService({{ $service->id }})">
                            <i class="bi bi-pencil"></i>
                        </button>
                    </div>
                    @endif
                @endauth
                
                <!-- Service Icon -->
                <div class="service-icon">
                    @if($service->category && $service->category->name === 'Bridal')
                        <i class="bi bi-heart-fill text-danger"></i>
                    @elseif($service->category && $service->category->name === 'Editorial')
                        <i class="bi bi-camera-fill text-primary"></i>
                    @else
                        <i class="bi bi-stars text-warning"></i>
                    @endif
                </div>
                
                <!-- Service Name -->
                <h3 class="h4 fw-bold mb-2">{{ $service->name }}</h3>
                
                <!-- Description -->
                <p class="text-secondary mb-3">{{ $service->description }}</p>
                
                <!-- Price -->
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="price-tag">${{ number_format($service->price, 2) }}</span>
                    
                </div>
                
                <!-- Availability -->
                <div class="mb-3">
                    @if($service->availability)
                        <span class="text-success"><i class="bi bi-check-circle-fill"></i> Available</span>
                    @else
                        <span class="text-danger"><i class="bi bi-x-circle-fill"></i> Currently Unavailable</span>
                    @endif
                </div>
                
                <!-- Book Button -->
                @if(!Auth::check() || !Auth::user()->isAdmin())
                    @if($service->availability)
                    <a href="{{ route('booking.create') }}?service={{ $service->id }}" 
                       class="btn btn-outline-dark w-100">
                        Book This Service
                    </a>
                    @else
                    <button class="btn btn-outline-secondary w-100" disabled>
                        Not Available
                    </button>
                    @endif
                @endif
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <i class="bi bi-scissors display-1 text-secondary"></i>
            <h3 class="mt-3">No services available</h3>
            <p class="text-secondary">Check back soon for our service offerings!</p>
        </div>
        @endforelse
    </div>
    
    <div class="row mt-5">
        <div class="col-lg-8 mx-auto">
            <div class="card border-0 bg-light">
                <div class="card-body p-4 text-center">
                    <i class="bi bi-car-front-fill fs-1 text-secondary mb-3"></i>
                    <h4 class="fw-bold mb-2">On-Location Services Available</h4>
                    <p class="text-secondary mb-0">
                        We travel to you! Serving Sydney, Melbourne, Brisbane & surrounding areas. 
                        Travel fees may apply for locations outside city centers.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Service (Admin Only) -->
@auth
    @if(Auth::user()->role === 'admin')
    <div class="modal fade" id="addServiceModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('admin.services.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Add New Service</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Service Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Price ($)</label>
                            <input type="number" name="price" class="form-control" step="0.01" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Category</label>
                            <select name="category_id" class="form-select" required>
                                <option value="">Select category...</option>
                                @foreach(\App\Models\Category::all() as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input type="checkbox" name="availability" class="form-check-input" value="1" checked>
                                <label class="form-check-label">Available for booking</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-dark">Add Service</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Edit Service -->
    <div class="modal fade" id="editServiceModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="editServiceForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Service</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Service Name</label>
                            <input type="text" name="name" id="edit_name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" id="edit_description" class="form-control" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Price ($)</label>
                            <input type="number" name="price" id="edit_price" class="form-control" step="0.01" required>
                        </div>
                       
                        <div class="mb-3">
                            <label class="form-label">Category</label>
                            <select name="category_id" id="edit_category" class="form-select" required>
                                @foreach(\App\Models\Category::all() as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input type="checkbox" name="availability" id="edit_availability" class="form-check-input" value="1">
                                <label class="form-check-label">Available for booking</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <button type="button" class="btn btn-outline-danger w-100" onclick="deleteService()">
                                <i class="bi bi-trash"></i> Delete Service
                            </button>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-dark">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
@endauth

<
@auth
    @if(Auth::user()->role === 'admin')
    <script>
        let currentServiceId = null;
        
        async function editService(id) {
            try {
                const response = await fetch(`/admin/services/${id}`);
                const service = await response.json();
                
                currentServiceId = service.id;
                document.getElementById('edit_name').value = service.name;
                document.getElementById('edit_description').value = service.description;
                document.getElementById('edit_price').value = service.price;
                document.getElementById('edit_category').value = service.category_id;
                document.getElementById('edit_availability').checked = service.availability;
                
                document.getElementById('editServiceForm').action = `/admin/services/${service.id}`;
                
                new bootstrap.Modal(document.getElementById('editServiceModal')).show();
            } catch (error) {
                alert('Error loading service data');
            }
        }
        
        async function deleteService() {
            if (!confirm('Are you sure you want to delete this service? This cannot be undone.')) {
                return;
            }
            
            try {
                const response = await fetch(`/admin/services/${currentServiceId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });
                
                if (response.ok) {
                    window.location.reload();
                } else {
                    alert('Error deleting service');
                }
            } catch (error) {
                alert('Error deleting service');
            }
        }
    </script>
    @endif
@endauth
@endsection