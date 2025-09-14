@extends('layouts.app')

@section('title', $post->title)

@section('content')
<div class="row">
    <div class="col-md-8">
        <article>
            @if($post->featured_image)
                <img src="{{ Storage::url($post->featured_image) }}" class="img-fluid rounded mb-4" alt="{{ $post->title }}">
            @endif
            
            <h1>{{ $post->title }}</h1>
            
            <div class="mb-4">
                @foreach($post->categories as $category)
                    <span class="badge bg-secondary me-1">{{ $category->name }}</span>
                @endforeach
            </div>
            
            <p class="text-muted mb-4">
                By {{ $post->user->name }} on {{ $post->published_at->format('F d, Y') }}
            </p>
            
            <div class="content mb-4">
                {!! nl2br(e($post->content)) !!}
            </div>
            
            @can('update', $post)
                <div class="border-top pt-3">
                    <a href="{{ route('posts.edit', $post) }}" class="btn btn-warning me-2">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <form action="{{ route('posts.destroy', $post) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </form>
                </div>
            @endcan
        </article>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5>About the Author</h5>
            </div>
            <div class="card-body">
                <h6>{{ $post->user->name }}</h6>
                <p class="text-muted">{{ $post->user->posts()->published()->count() }} published posts</p>
            </div>
        </div>
    </div>
</div>
@endsection