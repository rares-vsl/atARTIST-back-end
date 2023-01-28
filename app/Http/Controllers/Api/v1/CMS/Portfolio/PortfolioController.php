<?php


namespace App\Http\Controllers\Api\v1\CMS\Portfolio;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\Portfolio\CreatePortfolioRequest;
use App\Http\Requests\v1\Portfolio\UpdatePortfolioRequest;
use App\Http\Resources\v1\Portfolio\NewPortfolioResource;
use App\Http\Resources\v1\Portfolio\PortfolioCMSResource;
use App\Http\Resources\v1\Portfolio\PortfolioInfoResource;
use App\Models\Biography;
use App\Models\Contact;
use App\Models\Gallery;
use App\Models\Portfolio;
use App\Models\Section;
use App\Models\SectionCategory;
use Illuminate\Support\Facades\DB;

class PortfolioController extends Controller
{
    public function store(CreatePortfolioRequest $request)
    {
        DB::beginTransaction();

        $portfolio = Portfolio::create([
            'user_id' => $request->user()->id,
            'name' => $request->name,
            'icon' => false
        ]);

        $home = Section::create([
            'portfolio_id' => $portfolio->id,
            'category'     => SectionCategory::gallery(),
            'name'         => 'Home',
            'slug'         => 'home'
        ]);

        Gallery::create([
            'section_id' => $home->id,
            'index' => 1,
            'description' => 'Welcome to ' . $request->user()->username . '\'s Portfolio!',
        ]);

        $aboutMe = Section::create([
            'portfolio_id' => $portfolio->id,
            'category'     => SectionCategory::aboutMe(),
            'name'         => 'About me',
            'slug'         => 'about-me'
        ]);

        Biography::create([
            'section_id' => $aboutMe->id,
            'bio' => 'Hi! I\'m ' . $request->user()->username,
        ]);

        Contact::create([
            'section_id' => $aboutMe->id,
            'email' => $request->user()->email,
        ]);

        
        DB::commit();

        return $this->successResponse(
            [
                'message' => 'Portfolio created successfully',
                'portfolio' => new NewPortfolioResource($portfolio)
            ],
            200
        );
    }

    public function show(Portfolio $portfolio)
    {
        $this->authorize('ownsPortfolio', $portfolio);

        return $this->successResponse(
            [
                'portfolio' => new PortfolioCMSResource($portfolio)
            ],
            200
        );
    }

    public function update(UpdatePortfolioRequest $request, Portfolio $portfolio)
    {
        $this->authorize('ownsPortfolio', $portfolio);

        $portfolio->update([
            'name' => $request->name
        ]);

        return $this->successResponse(
            [
                'message' => 'Portfolio updated successfully',
                'portfolio' => new PortfolioInfoResource($portfolio)
            ],
            200
        );
    }

    public function destroy(Portfolio $portfolio)
    {
        $this->authorize('ownsPortfolio', $portfolio);
        $portfolio->delete();

        return $this->successResponse(
            [
                'message' => 'Portfolio\'s deleted successfully',
                'portfolio' => new PortfolioInfoResource($portfolio)
            ],
            200
        );
    }
}
