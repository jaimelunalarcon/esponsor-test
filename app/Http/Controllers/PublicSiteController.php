<?php

namespace App\Http\Controllers;

use App\Models\Site;
use Illuminate\View\View;

class PublicSiteController extends Controller
{
    public function show(string $slug): View
    {
        $site = Site::where('slug', $slug)->firstOrFail();

        $publishedPayload = $site->published_payload ?? ['blocks' => []];
        $blocks = $publishedPayload['blocks'] ?? [];

        usort($blocks, function ($a, $b) {
            return ($a['position'] ?? 0) <=> ($b['position'] ?? 0);
        });

        $blocks = array_values(array_filter($blocks, function ($block) {
            return ($block['enabled'] ?? true) !== false;
        }));

        return view('public-site.show', [
            'site' => $site,
            'blocks' => $blocks,
        ]);
    }
}