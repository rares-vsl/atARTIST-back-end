<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Gallery extends Model
{
    use HasFactory;

    protected $fillable = [
        'section_id',
        'index',
        'description'
    ];

    public function resolveRouteBinding($value, $field = null)
    {
        $portfolioId = request()->portfolio->id;

        $section = Section::where('portfolio_id', $portfolioId)
            ->where('slug', $value)
            ->where('category', SectionCategory::gallery())
            ->firstOrFail();

        return $this->where('section_id', $section->id)->firstOrFail();
    }

    // RELAZIONI

    public function posts()
    {
        return $this->hasMany(Post::class)->orderByDesc('created_at');
    }

    public function section()
    {
        return $this->belongsTo(Section::class)->withTrashed();
    }

    public function postCount(){
        return $this->loadCount('posts')->posts_count;
    }

    // METODI
    public function trashed()
    {
        $gallerySection = $this->section;

        return $gallerySection->trashed();
    }

    public function isArchived()
    {
        $gallerySection = $this->section;
        return isset($gallerySection->archived_at);
    }
}
