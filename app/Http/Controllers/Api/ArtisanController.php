<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Http\Request;

class ArtisanController extends Controller
{
    /**
     * Run php artisan route:cache
     * POST /api/artisan/route-cache
     */
    public function routeCache(): JsonResponse
    {
        try {
            Artisan::call('route:cache');
            $output = Artisan::output();

            return response()->json([
                'success' => true,
                'message' => 'route:cache executed successfully',
                'output' => trim($output),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'route:cache failed',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
