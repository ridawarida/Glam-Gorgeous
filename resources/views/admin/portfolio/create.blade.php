@extends('layouts.app')

@section('title', 'Upload Portfolio Image')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-lg-6 mx-auto">
            <h1 class="mb-4">Upload New Image</h1>
            
            <form action="{{ route('admin.portfolio.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="mb-3">
                    <label class="form-label">Image File</label>
                    <input type="file" name="image" class="form-control" accept="image/*" required>
                    @error('image')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Alt Text / Description</label>
                    <input type="text" name="alt_text" class="form-control" required>
                    @error('alt_text')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Category</label>
                    <select name="category_id" class="form-select" required>
                        <option value="">Select category...</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="mb-3">
                    <div class="form-check">
                        <input type="checkbox" name="is_before" class="form-check-input" id="is_before" value="1">
                        <label class="form-check-label" for="is_before">
                            This is a "Before" image (part of transformation pair)
                        </label>
                    </div>
                </div>
                
                <div class="mb-3" id="after_select" style="display: none;">
                    <label class="form-label">Link to "After" Image (Optional)</label>
                    <select name="after_image_id" class="form-select">
                        <option value="">Select after image...</option>
                        @foreach($galleryImages as $img)
                            <option value="{{ $img->id }}">#{{ $img->id }} - {{ Str::limit($img->alt_text, 40) }}</option>
                        @endforeach
                    </select>
                </div>
                
                <button type="submit" class="btn btn-dark">Upload Image</button>
                <a href="{{ route('admin.portfolio.index') }}" class="btn btn-outline-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('is_before').addEventListener('change', function() {
    document.getElementById('after_select').style.display = this.checked ? 'block' : 'none';
});
</script>
@endsection