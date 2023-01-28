<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'gallery_id',
        'title',
        'description',
        'slug',
        'media'
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function gallery(){
        return $this->belongsTo(Gallery::class);
    }

    public function mediaURL(){
        return 'posts/'.$this->gallery->section->portfolio_id.'/';
    }
}
