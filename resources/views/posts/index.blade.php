@extends('layouts.app')

@section('title', 'Latest Posts')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Latest Posts</h1>
            @auth
                <a href="{{ route('posts.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Write New Post
                </a>
            @endauth
        </div>

        @forelse($posts as $post)
            <article class="card mb-4">
                @if($post->featured_image)
                    <img src="{{ Storage::url($post->featured_image) }}" class="card-img-top" alt="{{ $post->title }}" style="height: 200px; object-fit: cover;">
                @endif
                
                <div class="card-body">
                    <h2 class="card-title">
                        <a href="{{ route('posts.show', $post) }}" class="text-decoration-none">
                            {{ $post->title }}
                        </a>
                    </h2>
                    
                    <p class="card-text text-muted">{{ $post->excerpt }}</p>
                    
                    <div class="mb-3">
                        @foreach($post->categories as $category)
                            <span class="badge bg-secondary me-1">{{ $category->name }}</span>
                        @endforeach
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">
                            By {{ $post->user->name }} on {{ $post->published_at->format('M d, Y') }}
                        </small>
                        <a href="{{ route('posts.show', $post) }}" class="btn btn-outline-primary btn-sm">
                            Read More
                        </a>
                    </div>
                </div>
            </article>
        @empty
            <div class="text-center py-5">
                <h3>No posts found</h3>
                <p class="text-muted">Be the first to write a post!</p>
                @auth
                    <a href="{{ route('posts.create') }}" class="btn btn-primary">Write First Post</a>
                @endauth
            </div>
        @endforelse

        {{ $posts->links() }}
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5>Categories</h5>
            </div>
            <div class="card-body">
                @foreach(App\Models\Category::withCount('posts')->get() as $category)
                    <a href="#" class="d-flex justify-content-between text-decoration-none mb-2">
                        <span>{{ $category->name }}</span>
                        <span class="badge bg-light text-dark">{{ $category->posts_count }}</span>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection