<?php

namespace App\Http\Controllers\LaravelControl;

use App\Http\Controllers\Controller;
use App\Services\LaravelControlService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LaravelControlController extends Controller
{
    protected LaravelControlService $service;

    public function __construct(LaravelControlService $service)
    {
        $this->service = $service;
    }

    /**
     * POST /command
     */
    public function command(Request $request): JsonResponse
    {
        $command = $request->input('command', '');

        if (empty(trim($command))) {
            return response()->json([
                'success' => false,
                'message' => 'No command provided',
            ]);
        }

        return response()->json($this->service->handleCommand($command));
    }

    /**
     * GET /status
     */
    public function status(): JsonResponse
    {
        return response()->json($this->service->getStatus());
    }

    /**
     * GET /branch
     */
    public function branch(): JsonResponse
    {
        $data = $this->service->getBranches();

        return response()->json([
            'success' => true,
            'data'    => $data,
        ]);
    }

    /**
     * POST /checkout
     */
    public function checkout(Request $request): JsonResponse
    {
        $route = $request->input('route', '');

        if (empty(trim($route))) {
            return response()->json([
                'success' => false,
                'message' => 'No route specified',
            ]);
        }

        return response()->json($this->service->checkout($route));
    }

    /**
     * GET /config
     */
    public function config(): JsonResponse
    {
        return response()->json($this->service->getConfig());
    }

    /**
     * GET /history
     */
    public function history(): JsonResponse
    {
        return response()->json($this->service->getHistory());
    }

    /**
     * GET /branches
     */
    public function branches(): JsonResponse
    {
        $data = $this->service->getBranches();

        return response()->json([
            'success' => true,
            'data'    => $data,
        ]);
    }

    /**
     * POST /show
     */
    public function show(Request $request): JsonResponse
    {
        $branch = $request->input('branch', '');

        if (empty(trim($branch))) {
            return response()->json([
                'success' => false,
                'message' => 'No branch specified',
            ]);
        }

        return response()->json($this->service->getShow($branch));
    }

    /**
     * POST /show-all
     */
    public function showAll(): JsonResponse
    {
        return response()->json($this->service->getShowAll());
    }
}
