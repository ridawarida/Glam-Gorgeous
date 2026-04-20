<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = ['user_id', 'appointment_id', 'content', 'rating', 'featured'];
    
    protected $casts = [
        'rating' => 'integer',
        'featured' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function appointment()
    {
        return $this->belongsTo(Appointment::class, 'appointment_id');
    }
    
    // Scope for featured reviews
    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }
}