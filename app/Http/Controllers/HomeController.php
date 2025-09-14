<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $featuredPosts = Post::with('categories', 'user')
                            ->where('published', true)
                            ->latest('published_at')
                            ->take(3)
                            ->get();
                            
        $recentPosts = Post::with('categories', 'user')
                          ->where('published', true)
                          ->latest('published_at')
                          ->take(6)
                          ->get();
                          
        $categories = Category::withCount('posts')
                            ->orderBy('posts_count', 'desc')
                            ->take(10)
                            ->get();
        
        return view('home', compact('featuredPosts', 'recentPosts', 'categories'));
    }
}