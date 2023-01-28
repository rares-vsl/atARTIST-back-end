<?php

namespace App\Models;

use App\Http\Resources\v1\AboutMe\AboutMeResource;
use App\Http\Resources\v1\AboutMe\AboutMeSectionResource;
use App\Http\Resources\v1\Gallery\GalleriesResource;
use App\Http\Resources\v1\Section\SectionsResource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Portfolio extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'name',
        'icon',
        'archived_at'
    ];

    public function getRouteKeyName()
    {
        return 'name';
    }

    // RELAZIONI
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sections()
    {
        return $this->hasMany(Section::class);
    }

    public function galleries()
    {
        return $this->hasManyThrough(Gallery::class, Section::class);
    }

    public function homeSection()
    {
        return $this->galleries()
            ->with('section')
            ->where('sections.archived_at', null)
            ->where('index', 1);
    }

    public function getHomeSectionSlug()
    {
        return $this->homeSection()->first()->section->slug;
    }

    public function portfolioGalleries()
    {
        return $this->galleries()
            ->with('section')
            ->withCount('posts')
            ->orderBy('index')
            ->orderByDesc('archived_at');
    }

    public function getPublicSections()
    {
        $galleries = SectionsResource::collection(
            $this->sections()
                ->where('archived_at', null)
                ->with('gallery')
                ->where('category', SectionCategory::gallery())
                ->get()
        )->sortBy('gallery.index')->values();

        $aboutMe = SectionsResource::collection(
            $this->sections()
                ->where('archived_at', null)
                ->with('gallery')
                ->where('category', SectionCategory::aboutMe())
                ->get()
        )->sortBy('gallery.index')->values();;

        $sections = new \Illuminate\Database\Eloquent\Collection;
        $sections = $sections->concat($galleries);
        $sections = $sections->concat($aboutMe);

        return $sections;
    }

    public function publicGalleries()
    {
        return $this->portfolioGalleries()
            ->where('sections.archived_at', null);
    }

    // public function archivedGalleries()
    // {
    //     return $this->portfolioGalleries()
    //         ->where('sections.archived_at', 'IS NOT', null);
    // }

    public function deletedGalleries()
    {
        return $this->portfolioGalleries()
            ->withTrashedParents()
            ->where('sections.deleted_at', 'IS NOT', null);
    }

    public function aboutMe()
    {
        return  $this->sections()
            ->where('category', SectionCategory::aboutMe());
    }

    public function getAboutMe()
    {
        return new AboutMeResource($this->aboutMe()->first());
    }

    public function getAboutMeSection()
    {
        $aboutMeSection = $this->aboutMe()
            ->with('biography', 'contact')
            ->first();

        return new AboutMeSectionResource($aboutMeSection);
    }

    public function CMSSectionsWithInfo()
    {
        return [
            'galleries' => $this->getCMSGalleries(),
            'about_me' => $this->getAboutMe()
        ];
    }

    public function getCMSGalleries()
    {
        return GalleriesResource::collection(
            $this->portfolioGalleries
        );
    }

    public function getDeletedGalleries()
    {
        return GalleriesResource::collection(
            $this->deletedGalleries
        );
    }

    public function publicGalleriesCount()
    {
        return $this->loadCount('publicGalleries')->public_galleries_count;
    }

    // METODI

    public function isArchived()
    {
        return isset($this->archived_at);
    }

    public function icon()
    {
        $baseURL = 'media/portfolio/icon/';
        if ($this?->icon)
            return $baseURL . 'icon-' . $this->id . '.png';
        return $baseURL . 'default.png';
    }

    public function decrementPublicGalleriesIndex($min, $max)
    {
        $this->publicGalleries()
            ->whereBetween('index', [$min, $max])
            ->decrement('index');
    }

    public function incrementPublicGalleriesIndex($min, $max)
    {
        $this->publicGalleries()
            ->whereBetween('index', [$min, $max])
            ->increment('index');
    }
}
