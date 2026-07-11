<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function __invoke(): Response
    {
        $projects = Project::query()
            ->orderBy('sort_order')
            ->get(['id', 'title', 'slug', 'thumbnail', 'technologies', 'status', 'sort_order']);

        return Inertia::render('admin/Dashboard', [
            'stats' => [
                'total' => $projects->count(),
                'published' => $projects->where('status', true)->count(),
                'draft' => $projects->where('status', false)->count(),
                'technologies' => $projects->pluck('technologies')->flatten()->unique()->count(),
            ],
            'recentProjects' => $projects->take(5)->values(),
        ]);
    }
}
