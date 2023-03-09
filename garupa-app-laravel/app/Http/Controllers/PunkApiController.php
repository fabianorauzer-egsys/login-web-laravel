<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Pagination\Paginator;

class PunkApiController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->session()->has('token')) {
            return redirect()
                ->route("auth");
        }
        $client = new Client(['base_uri' => 'https://api.punkapi.com/v2/']);

        $beersCount = $this->getCount();
        $page = $request->query('page') ?? 1;
        $page = $page == 0 ? 1 : $page;
        $perPage = $request->query('per_page') ?? 10;
        $abv = $request->query('abv') ?? null;
        $ibu = $request->query('ibu') ?? null;
        $query = $request->query('query') ?? null;
        $sort = $request->query('sort') ?? 'name';
        $qtyPages = floor($beersCount / $perPage);
        $response = $client->request('GET', 'beers', [
            'query' => [
                'page' => $page,
                'per_page' => $perPage,
                'abv_gt' => $abv,
                'ibu_gt' => $ibu,
                'beer_name' => $query,
                'sort' => $sort,
            ],
        ]);

        $beers = collect(json_decode($response->getBody()));
        $viewBag = [
            'beers' => $beers,
            'session' => $request->session(),
            'count' => $beersCount,
            'qtyPages' => $qtyPages
        ];
        return view('beers', $viewBag);
    }

    private function getCount()
    {
        $client = new Client(['base_uri' => 'https://api.punkapi.com/v2/']);
        $response = $client->request('GET', 'beers', [
            'query' => [
                'page' => 2,
                'per_page' => 80,
            ],
        ]);
        $beers = collect(json_decode($response->getBody()));
        return $beers->count();
    }
}
