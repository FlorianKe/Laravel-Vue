<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function __invoke(Request $request): Response
    {
        return Inertia::render('Dashboard', [
            'quote' => $this->getQuote(),
        ]);
    }

    /**
     * @return array{quote: string, author: string}
     */
    private function getQuote()
    {
        return Cache::remember('quote', now()->addMinutes(10), function () {
            $response = Http::get('https://zenquotes.io/api/today')
                ->throw()
                ->collect()
                ->first();

            return [
                'quote' => data_get($response, 'q', 'No quote available'),
                'author' => data_get($response, 'a', 'System'),
            ];
        });
    }
}
