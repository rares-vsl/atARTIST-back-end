<?php

namespace App\Http\Controllers\Api\v1\Public;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\Section\ShowPublicSectionRequest;
use App\Models\Portfolio;
use App\Models\Section;

class SectionController extends Controller
{
    public function show(
        ShowPublicSectionRequest $request,
        Portfolio $portfolio,
        Section $section)
    {
        return $section;
    }
}
