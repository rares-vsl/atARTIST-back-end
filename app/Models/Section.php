<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Section extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'portfolio_id',
        'category',
        'name',
        'slug',
        'archived_at'
    ];

    public function gallery()
    {
        return $this->hasOne(Gallery::class);
    }

    public function biography()
    {
        return $this->hasOne(Biography::class);
    }

    public function contact()
    {
        return $this->hasOne(Contact::class);
    }

    public static function resolveGallery($portfolioID, $slug)
    {
        return Section::withTrashed()
            ->where('portfolio_id', $portfolioID)
            ->where('slug', $slug)
            ->where('category', SectionCategory::gallery())
            ->firstOrFail();
    }

    public function resolveRouteBinding($value, $field = null)
    {
        $portfolioId = request()->portfolio->id;

        return $this->where('portfolio_id', $portfolioId)
            ->where('slug', $value)
            ->firstOrFail();
    }

    public function isArchived()
    {
        return isset($this->archived_at);
    }
}
