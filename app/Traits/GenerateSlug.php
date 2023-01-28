<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

trait GenerateSlug{
    public static function generateUniqueSlug(string $table): string
    {
        do {
            $slug = Str::random(12);
        }while (GenerateSlug::slugExists($slug, $table));
        
        return $slug;
    }

    public static function slugExists(string $slug, string $table): bool
    {
        $query = DB::table($table)->where('slug', $slug);

        return $query->exists();
    }
}

?>