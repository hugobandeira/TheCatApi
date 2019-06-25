<?php

namespace App\Service;

use GuzzleHttp\Client;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class BreedService
{
    /**
     * @var string
     */
    private $token;

    /**
     * BreedService constructor.
     */
    public function __construct()
    {
        $this->token = env('TOKEN_THE_CAT', '');
    }

    /**
     * @return Client
     */
    private function getClient() : Client
    {
        return new Client([
            'base_uri' => 'https://api.thecatapi.com/v1/',
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json; charset=utf-8',
            ],
        ]);
    }

    /**
     * @return array
     */
    public function getBreed()
    {
        try {
            return collect(
                json_decode(
                    $this
                        ->getClient()
                        ->get('breeds')
                        ->getBody()
                        ->getContents()
                    , true)
            );
        } catch (\Exception $exception) {
            Log::error($exception);
            return collect();
        }
    }

    /**
     * @param string $search
     * @return Collection
     */
    public function getBreeadSearch(string $search)
    {
        try {
            return collect(json_decode($this
                ->getClient()
                ->get('breeds/search', [
                    'query' => [
                        'q' => $search,
                    ],
                ])
                ->getBody()
                ->getContents(), true));

        } catch (\Exception $exception) {
            Log::error($exception);
            return collect();
        }
    }

    /**
     * @return Collection
     */
    public function getTest()
    {
        return collect(
            json_decode(
                $this
                    ->getClient()
                    ->get('breeds')
                    ->getBody()
                    ->getContents()
                , true)
        );
    }
}