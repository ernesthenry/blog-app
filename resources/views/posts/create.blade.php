@extends('layouts.app')

@section('title', 'Create New Post - Laravel Blog')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h4>Create New Post</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="title" class="form-label">Title *</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" 
                               id="title" name="title" value="{{ old('title') }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="excerpt" class="form-label">Excerpt *</label>
                        <textarea class="form-control @error('excerpt') is-invalid @enderror" 
                                  id="excerpt" name="excerpt" rows="3" required>{{ old('excerpt') }}</textarea>
                        @error('excerpt')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="content" class="form-label">Content *</label>
                        <textarea class="form-control @error('content') is-invalid @enderror" 
                                  id="content" name="content" rows="10" required>{{ old('content') }}</textarea>
                        @error('content')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="featured_image" class="form-label">Featured Image</label>
                        <input type="file" class="form-control @error('featured_image') is-invalid @enderror" 
                               id="featured_image" name="featured_image" accept="image/*">
                        @error('featured_image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Accepted formats: JPEG, PNG, JPG, GIF. Max size: 2MB</div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="categories" class="form-label">Categories</label>
                        <select multiple class="form-select @error('categories') is-invalid @enderror" 
                                id="categories" name="categories[]" size="5">
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}" 
                                {{ (in_array($category->id, old('categories', [])) || (isset($selectedCategory) && $category->id == $selectedCategory)) ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('categories')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Hold Ctrl/Cmd to select multiple categories</div>
                    </div>
                    
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" name="published" 
                               value="1" id="published" {{ old('published') ? 'checked' : '' }}>
                        <label class="form-check-label" for="published">
                            Publish immediately
                        </label>
                    </div>
                    
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('posts.index') }}" class="btn btn-secondary me-md-2">Cancel</a>
                        <button type="submit" class="btn btn-primary">Create Post</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
    // Add some interactivity to the form
    document.addEventListener('DOMContentLoaded', function() {
        const titleInput = document.getElementById('title');
        const excerptInput = document.getElementById('excerpt');
        
        // Auto-generate excerpt from first 150 characters of content if empty
        document.getElementById('content').addEventListener('blur', function() {
            if (!excerptInput.value && this.value.length > 0) {
                excerptInput.value = this.value.substring(0, 150) + (this.value.length > 150 ? '...' : '');
            }
        });
        
        // Preview image before upload
        const featuredImageInput = document.getElementById('featured_image');
        featuredImageInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    // Remove any existing preview
                    const existingPreview = document.getElementById('image-preview');
                    if (existingPreview) {
                        existingPreview.remove();
                    }
                    
                    // Create preview element
                    const preview = document.createElement('div');
                    preview.id = 'image-preview';
                    preview.className = 'mt-3';
                    preview.innerHTML = `
                        <p class="form-text">Image Preview:</p>
                        <img src="${e.target.result}" class="img-thumbnail" style="max-height: 200px;">
                    `;
                    
                    featuredImageInput.parentNode.appendChild(preview);
                };
                reader.readAsDataURL(file);
            }
        });
    });
</script>
@endsection