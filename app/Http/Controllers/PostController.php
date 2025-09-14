<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Services\FileUploadService;


class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    public function index()
    {
        $posts = Post::with(['user', 'categories'])
                    ->published()
                    ->latest('published_at')
                    ->paginate(10);

        return view('posts.index', compact('posts'));
    }

    public function create(Request $request)
    {
        $categories = Category::all();
        $selectedCategory = $request->get('category');
        return view('posts.create', compact('categories', 'selectedCategory'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'excerpt' => 'nullable|max:500',
            'featured_image' => 'nullable|image|max:2048',
            'categories' => 'array',
            'categories.*' => 'exists:categories,id',
            'published' => 'boolean'
        ]);

        $post = new Post($validated);
        $post->user_id = Auth::id();
        
        if ($request->hasFile('featured_image')) {
            $path = $request->file('featured_image')->store('posts', 'public');
            $post->featured_image = $path;
        }

        if ($post->published) {
            $post->published_at = now();
        }

        $post->save();

        if (isset($validated['categories'])) {
            $post->categories()->sync($validated['categories']);
        }

        return redirect()->route('posts.index')
                        ->with('success', 'Post created successfully!');
    }

    public function show(Post $post)
    {
        try {
            $post->load(['user', 'categories']);
            
            // Try to load comments, but catch any errors
            if (\Illuminate\Support\Facades\Schema::hasTable('comments')) {
                try {
                    $post->load(['comments.user', 'comments.replies.user']);
                } catch (\Exception $e) {
                    // If comments loading fails, just continue without them
                    \Log::warning('Failed to load comments: ' . $e->getMessage());
                }
            }
            
            return view('posts.show', compact('post'));
        } catch (\Exception $e) {
            // Log the error and show a friendly message
            \Log::error('Post show error: ' . $e->getMessage());
            return redirect()->route('posts.index')
                ->with('error', 'Sorry, there was an error loading this post.');
        }
    }
        

    public function edit(Post $post)
    {
        $this->authorize('update', $post);
        $categories = Category::all();
        return view('posts.edit', compact('post', 'categories'));
    }

    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post);

        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'excerpt' => 'nullable|max:500',
            'featured_image' => 'nullable|image|max:2048',
            'categories' => 'array',
            'categories.*' => 'exists:categories,id',
            'published' => 'boolean'
        ]);

        if ($request->hasFile('featured_image')) {
            // Delete old image
            if ($post->featured_image) {
                Storage::disk('public')->delete($post->featured_image);
            }
            
            $path = $request->file('featured_image')->store('posts', 'public');
            $validated['featured_image'] = $path;
        }

        // Set published_at when publishing for first time
        if ($validated['published'] && !$post->published) {
            $validated['published_at'] = now();
        }

        $post->update($validated);

        if (isset($validated['categories'])) {
            $post->categories()->sync($validated['categories']);
        }

        return redirect()->route('posts.show', $post)
                        ->with('success', 'Post updated successfully!');
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);

        if ($post->featured_image) {
            Storage::disk('public')->delete($post->featured_image);
        }

        $post->delete();

        return redirect()->route('posts.index')
                        ->with('success', 'Post deleted successfully!');
    }
}