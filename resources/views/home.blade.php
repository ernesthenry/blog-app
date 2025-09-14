@extends('layouts.app')

@section('title', 'Home - Laravel Blog')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <!-- Featured Posts -->
        <section class="mb-5">
            <h2 class="mb-4">Featured Posts</h2>
            <div class="row">
                @foreach($featuredPosts as $post)
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        @if($post->featured_image)
                        <img src="{{ asset('storage/' . $post->featured_image) }}" class="card-img-top" alt="{{ $post->title }}" style="height: 200px; object-fit: cover;">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $post->title }}</h5>
                            <p class="card-text">{{ Str::limit($post->excerpt, 100) }}</p>
                            <div class="mb-2">
                                @foreach($post->categories as $category)
                                <span class="badge bg-secondary">{{ $category->name }}</span>
                                @endforeach
                            </div>
                            <a href="{{ route('posts.show', $post) }}" class="btn btn-primary">Read More</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </section>

        <!-- Recent Posts -->
        <section>
            <h2 class="mb-4">Recent Posts</h2>
            @foreach($recentPosts as $post)
            <div class="card mb-3">
                <div class="row g-0">
                    @if($post->featured_image)
                    <div class="col-md-4">
                        <img src="{{ asset('storage/' . $post->featured_image) }}" class="img-fluid rounded-start" alt="{{ $post->title }}" style="height: 200px; object-fit: cover; width: 100%;">
                    </div>
                    @endif
                    <div class="{{ $post->featured_image ? 'col-md-8' : 'col-12' }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $post->title }}</h5>
                            <p class="card-text">{{ Str::limit($post->excerpt, 150) }}</p>
                            <p class="card-text">
                                <small class="text-muted">
                                    Published {{ $post->published_at->diffForHumans() }} by {{ $post->user->name }}
                                </small>
                            </p>
                            <a href="{{ route('posts.show', $post) }}" class="btn btn-outline-primary">Read More</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </section>
    </div>

    <div class="col-lg-4">
        <!-- Categories -->
        <div class="card mb-4">
            <div class="card-header">
                <h5>Categories</h5>
            </div>
            <div class="card-body">
                <div class="d-flex flex-wrap gap-2">
                    @foreach($categories as $category)
                    <span class="badge bg-primary">{{ $category->name }} ({{ $category->posts_count }})</span>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- About -->
        <div class="card">
            <div class="card-header">
                <h5>About</h5>
            </div>
            <div class="card-body">
                <p>Welcome to our Laravel Blog! Here you'll find the latest articles on web development, programming tips, and technology news.</p>
            </div>
        </div>
    </div>
</div>
@endsection