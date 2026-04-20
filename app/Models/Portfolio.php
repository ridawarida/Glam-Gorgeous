<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Portfolio extends Model
{
    protected $table = 'portfolio';
    
    protected $fillable = [
        'image_path', 'alt_text', 'category_id', 
        'is_before', 'after_image_id'
    ];
    
    protected $casts = [
        'is_before' => 'boolean',
    ];
    
    public function getImageUrlAttribute()
    {
        return $this->image_path ? Storage::disk('public')->url($this->image_path) : null;
    }
    
    protected static function booted()
    {
        static::deleting(function ($portfolio) {
            if ($portfolio->image_path) {
                Storage::disk('public')->delete($portfolio->image_path);
            }
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    
    public function afterImage()
    {
        return $this->belongsTo(Portfolio::class, 'after_image_id');
    }
    
    public function beforeImage()
    {
        return $this->hasOne(Portfolio::class, 'after_image_id');
    }
    
    public function favouritedBy()
    {
        return $this->belongsToMany(User::class, 'favourites', 'portfolio_id', 'client_id');
    }

    public function isFavouritedBy($user)
    {
        if (!$user) return false;
        return $this->favouritedBy()->where('client_id', $user->id)->exists();
    }
    
    public function scopeBefore($query)
    {
        return $query->where('is_before', true)->whereNotNull('after_image_id');
    }
    
    public function scopeGallery($query)
    {
        return $query->where('is_before', false)->whereNull('after_image_id');
    }
}