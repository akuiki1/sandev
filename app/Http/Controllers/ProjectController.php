<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Inertia\Inertia;
use Inertia\Response;

class ProjectController extends Controller
{
    public function show(Project $project): Response
    {
        abort_unless($project->status, 404);

        return Inertia::render('public/ProjectDetail', [
            'project' => $project->only([
                'id',
                'title',
                'slug',
                'summary',
                'thumbnail',
                'case_study',
                'solution',
                'features',
                'technologies',
                'screenshots',
                'github_url',
                'demo_url',
                'status',
                'sort_order',
            ]),
        ]);
    }
}
