<?php

namespace App\Http\Controllers;

use App\Breed;
use App\Http\Resources\BreedResource;
use App\Service\BreedService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BreedController extends Controller
{
    /**
     * @param Request $request
     * @return BreedResource
     */
    public function index(Request $request)
    {
        $breed = collect();
        $breed_db = $this->getBreedBd($request->input('name', ''));

        if ($breed_db) {
            $breed = $breed_db;
        } else {
            $breed_service = new BreedService();
            $breed = $breed_service->getBreeadSearch($request->input('name', ''));
        }
        return new BreedResource($breed);
    }

    /**
     * @param Breed $breed
     * @return Breed
     */
    public function show(Breed $breed)
    {
        return $breed;
    }

    /**
     * @param $search
     * @return mixed
     */
    private function getBreedBd(string $search)
    {
        try {
            $breeds = Breed::orderBy('name');
            if ($search) {
                $breeds->where('name', 'like', '%' . $search . '%');
            }

            if (!$breeds->count()) {
                $breed_service = new BreedService();
                $result = $breed_service->getBreeadSearch($search);
                foreach ($result as $item) {
                    unset(
                        $item['weight'],
                        $item['cfa_url'],
                        $item['vetstreet_url'],
                        $item['vcahospitals_url'],
                        $item['description'],
                        $item['country_codes'],
                        $item['indoor'],
                        $item['lap'],
                        $item['suppressed_tail'],
                        $item['weight_imperial'],
                        $item['alt_names'],
                        $item['cat_friendly'],
                        $item['extinct'],
                        $item['bidability']
                    );
                    Breed::updateOrCreate($item);
                }
            }
            return $breeds->paginate();

        } catch (\Exception $exception) {
            Log::error($exception);
            return false;
        }
    }
}
