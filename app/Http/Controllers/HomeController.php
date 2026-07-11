<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    public function __invoke(): Response
    {
        $projects = Project::query()
            ->published()
            ->orderBy('sort_order')
            ->get(['id', 'title', 'slug', 'summary', 'thumbnail', 'technologies']);

        return Inertia::render('public/Home', [
            'projects' => $projects,
        ]);
    }
}
