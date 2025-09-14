@extends('layouts.app')

@section('title', $post->title . ' - Laravel Blog')

@section('content')
<article class="mb-5">
    @if($post->featured_image)
    <img src="{{ asset('storage/' . $post->featured_image) }}" class="img-fluid rounded mb-4" alt="{{ $post->title }}" style="width: 100%; height: 400px; object-fit: cover;">
    @endif
    
    <h1 class="mb-3">{{ $post->title }}</h1>
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            @foreach($post->categories as $category)
            <span class="badge bg-primary me-1">{{ $category->name }}</span>
            @endforeach
        </div>
        <div class="text-muted">
            <small>
                Published {{ $post->published_at->diffForHumans() }} by {{ $post->user->name }}
            </small>
        </div>
    </div>
    
    <div class="mb-4">
        <p class="lead">{{ $post->excerpt }}</p>
    </div>
    
    <div class="post-content mb-5">
        {!! nl2br(e($post->content)) !!}
    </div>
</article>

<!-- Comments Section -->
<section class="mt-5">
    <h3>Comments ({{ $post->comments->count() }})</h3>
    
    @auth
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('comments.store', $post) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="content" class="form-label">Add a comment</label>
                    <textarea class="form-control" id="content" name="content" rows="3" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Post Comment</button>
            </form>
        </div>
    </div>
    @else
    <div class="alert alert-info">
        Please <a href="{{ route('login') }}">login</a> to leave a comment.
    </div>
    @endauth

    <div class="comments">
        @foreach($post->comments->where('parent_id', null) as $comment)
            @include('comments._comment', ['comment' => $comment])
        @endforeach
    </div>
</section>

<hr class="my-5">

<div class="d-flex justify-content-between">
    <a href="{{ route('posts.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Back to Posts
    </a>
    <div>
        @can('update', $post)
        <a href="{{ route('posts.edit', $post) }}" class="btn btn-outline-primary me-2">
            <i class="fas fa-edit"></i> Edit
        </a>
        @endcan
        @can('delete', $post)
        <form action="{{ route('posts.destroy', $post) }}" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Are you sure?')">
                <i class="fas fa-trash"></i> Delete
            </button>
        </form>
        @endcan
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Add some interactivity
    document.addEventListener('DOMContentLoaded', function() {
        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    });
</script>
@endsection