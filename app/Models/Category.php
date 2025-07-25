<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    
    protected $fillable = ['name', 'img'];
    
    // If you need the relationship with destinations as in your schema
    // public function destinations()
    // {
    //     return $this->belongsToMany(Destination::class, 'destination_categories');
    // }
}