<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favourite extends Model
{
    protected $table = 'favourites';
    protected $fillable = ['client_id', 'portfolio_id'];

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function portfolio()
    {
        return $this->belongsTo(Portfolio::class, 'portfolio_id');
    }
}