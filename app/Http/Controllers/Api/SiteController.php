<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpsertSiteRequest;
use App\Models\Site;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function show(Request $request): JsonResponse
    {
        $site = $request->user()->site;

        if (! $site) {
            return response()->json([
                'data' => null,
                'message' => 'No hay sitio aún.',
            ]);
        }

        return response()->json([
            'data' => $site,
        ]);
    }

    public function upsert(UpsertSiteRequest $request): JsonResponse
    {
        $user = $request->user();
        $existingSite = $user->site;

        $site = Site::updateOrCreate(
        ['user_id' => $user->id],
        [
            'user_id' => $user->id,
            'public_name' => $request->input('public_name'),
            'slug' => $request->input('slug'),
            'bio' => $request->input('bio'),
            'avatar_url' => $request->input('avatar_url'),
            'banner_url' => $request->input('banner_url'),
            'draft_payload' => $request->input('draft_payload', $existingSite?->draft_payload ?? [
                'blocks' => [],
            ]),
            'published_payload' => $existingSite?->published_payload,
        ]
    );

        return response()->json([
            'message' => 'Sitio guardado correctamente.',
            'data' => $site,
        ]);
    }

    public function publish(Request $request): JsonResponse
    {
        $site = $request->user()->site;

        abort_unless($site, 404);

        $site->published_payload = $site->draft_payload;
        $site->save();

        return response()->json([
            'message' => 'Sitio publicado correctamente.',
            'data' => $site,
        ]);
    }
}