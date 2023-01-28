<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SectionCategory extends Model
{
    use HasFactory;

    protected $primaryKey = 'category';
    public $incrementing = false;
    protected $fillable = ['category'];

    public static function gallery()
    {
        return 'gallery';
    }

    public static function aboutMe()
    {
        return 'about-me';
    }

}
