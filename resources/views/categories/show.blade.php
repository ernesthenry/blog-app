@extends('layouts.app')

@section('title', $category->name . ' - Laravel Blog')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Category: {{ $category->name }}</h1>
            <div>
                <a href="{{ route('categories.edit', $category) }}" class="btn btn-primary me-2">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <form action="{{ route('categories.destroy', $category) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure? This will remove this category from all posts.')">
                        <i class="fas fa-trash"></i> Delete
                    </button>
                </form>
            </div>
        </div>

        @if($category->description)
        <div class="card mb-4">
            <div class="card-body">
                <p class="card-text">{{ $category->description }}</p>
            </div>
        </div>
        @endif

        <h3 class="mb-4">Posts in this category ({{ $posts->total() }})</h3>
        
        @if($posts->count() > 0)
            @foreach($posts as $post)
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">{{ $post->title }}</h5>
                    <p class="card-text">{{ Str::limit($post->excerpt, 150) }}</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">
                            Published {{ $post->published_at->diffForHumans() }} by {{ $post->user->name }}
                        </small>
                        <a href="{{ route('posts.show', $post) }}" class="btn btn-sm btn-outline-primary">Read More</a>
                    </div>
                </div>
            </div>
            @endforeach

            <div class="d-flex justify-content-center">
                {{ $posts->links() }}
            </div>
        @else
            <div class="alert alert-info">
                No posts found in this category.
            </div>
        @endif
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h5>Category Details</h5>
            </div>
            <div class="card-body">
                <p><strong>Slug:</strong> {{ $category->slug }}</p>
                <p><strong>Total Posts:</strong> {{ $posts->total() }}</p>
                <p><strong>Created:</strong> {{ $category->created_at->diffForHumans() }}</p>
                <p><strong>Last Updated:</strong> {{ $category->updated_at->diffForHumans() }}</p>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header">
                <h5>Actions</h5>
            </div>
            <div class="card-body">
                <a href="{{ route('categories.index') }}" class="btn btn-secondary w-100 mb-2">
                    <i class="fas fa-arrow-left"></i> Back to Categories
                </a>
                <a href="{{ route('posts.create') }}?category={{ $category->id }}" class="btn btn-primary w-100">
                    <i class="fas fa-plus"></i> Add Post to this Category
                </a>
            </div>
        </div>
    </div>
</div>
@endsection