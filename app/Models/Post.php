<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'excerpt',
        'featured_image',
        'published',
        'published_at',
        'user_id'
    ];

    protected $casts = [
        'published' => 'boolean',
        'published_at' => 'datetime'
    ];

    // Relationship: Post belongs to User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship: Post belongs to many Categories
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    // Automatically generate slug from title
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($post) {
            if (empty($post->slug)) {
                $post->slug = Str::slug($post->title);
            }
        });
    }

    // Scope for published posts
    public function scopePublished($query)
    {
        return $query->where('published', true);
    }

    // Accessor for excerpt
    public function getExcerptAttribute($value)
    {
        return $value ?: Str::limit(strip_tags($this->content), 150);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function approvedComments()
    {
        return $this->comments()->where('is_approved', true);
    }
    
}