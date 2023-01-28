<?php

namespace App\Http\Controllers\Api\v1\CMS\AboutMe;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\AboutMe\UpdateAboutMeRequest;
use App\Models\Portfolio;
use App\Models\Section;
use Illuminate\Http\Request;

class AboutMeController extends Controller
{
    public function show(Portfolio $portfolio)
    {
        $this->authorize('ownsPortfolio', $portfolio);

        return $this->successResponse(
            ['about_me' => $portfolio->getAboutMeSection()],
            200
        );
    }

    public function update(UpdateAboutMeRequest $request, Portfolio $portfolio)
    {
        $this->authorize('ownsPortfolio', $portfolio);

        $portfolio->aboutMe()->first()->biography()->update([
            'bio' => $request->biography
        ]);


        $portfolio->aboutMe()->first()->contact()->update([
            'email' => $request->contact
        ]);

        return $this->successResponse(
            [
                'message' => 'Infromation updated successfully',
                'about_me' => $portfolio->getAboutMeSection()
            ],
            200
        );
    }
}
