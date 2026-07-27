<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class ProjectController extends Controller
{
    public function index(): Response
    {
        $projects = Project::query()
            ->orderBy('sort_order')
            ->get(['id', 'title', 'slug', 'thumbnail', 'status', 'sort_order']);

        return Inertia::render('admin/projects/Index', [
            'projects' => $projects,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('admin/projects/Form', [
            'project' => null,
            'nextOrder' => (int) Project::query()->max('sort_order') + 1,
        ]);
    }

    public function store(StoreProjectRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('projects', 'public');
        }

        $data['screenshots'] = $this->storeScreenshots($request);
        unset($data['existing_screenshots']);

        $project = Project::query()->create($data);

        return redirect()
            ->route('admin.projects.index')
            ->with('message', "Project {$project->title} berhasil ditambahkan.");
    }

    public function edit(Project $project): Response
    {
        return Inertia::render('admin/projects/Form', [
            'project' => $project->only([
                'id',
                'title',
                'slug',
                'thumbnail',
                'summary',
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
            'nextOrder' => null,
        ]);
    }

    public function update(UpdateProjectRequest $request, Project $project): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('thumbnail')) {
            if ($project->thumbnail) {
                Storage::disk('public')->delete($project->thumbnail);
            }

            $data['thumbnail'] = $request->file('thumbnail')->store('projects', 'public');
        } else {
            unset($data['thumbnail']);
        }

        $keptScreenshots = array_values(array_intersect(
            array_map(static fn (mixed $path): string => (string) $path, (array) $request->input('existing_screenshots', [])),
            $project->screenshots,
        ));

        foreach (array_diff($project->screenshots, $keptScreenshots) as $removed) {
            Storage::disk('public')->delete($removed);
        }

        $data['screenshots'] = [...$keptScreenshots, ...$this->storeScreenshots($request)];
        unset($data['existing_screenshots']);

        $project->update($data);

        return redirect()
            ->route('admin.projects.index')
            ->with('message', "Perubahan pada {$project->title} disimpan.");
    }

    public function destroy(Project $project): RedirectResponse
    {
        $project->delete();

        return redirect()
            ->route('admin.projects.index')
            ->with('message', "Project {$project->title} dihapus (soft delete).")
            ->with('undoId', $project->id);
    }

    public function toggleStatus(Project $project): RedirectResponse
    {
        $project->update(['status' => ! $project->status]);

        return back();
    }

    public function restore(int $id): RedirectResponse
    {
        Project::withTrashed()->findOrFail($id)->restore();

        return redirect()->route('admin.projects.index');
    }

    /**
     * Store the newly uploaded screenshots on the public disk.
     *
     * @return array<int, string>
     */
    private function storeScreenshots(StoreProjectRequest $request): array
    {
        $paths = [];

        foreach ((array) $request->file('screenshots', []) as $screenshot) {
            $paths[] = $screenshot->store('projects/screenshots', 'public');
        }

        return $paths;
    }
}
