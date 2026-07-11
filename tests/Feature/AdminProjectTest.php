<?php

use App\Models\Project;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    $this->actingAs(User::factory()->create());
});

it('renders the dashboard with portfolio stats', function () {
    Project::factory()->published()->count(2)->create();
    Project::factory()->create();

    $this->get(route('admin.dashboard'))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('admin/Dashboard')
            ->where('stats.total', 3)
            ->where('stats.published', 2)
            ->where('stats.draft', 1)
            ->has('recentProjects', 3));
});

it('lists all projects including drafts', function () {
    Project::factory()->published()->create();
    Project::factory()->create();

    $this->get(route('admin.projects.index'))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('admin/projects/Index')
            ->has('projects', 2));
});

it('stores a new project', function () {
    $this->post(route('admin.projects.store'), [
        'title' => 'Sistem Baru',
        'slug' => 'sistem-baru',
        'summary' => 'Ringkasan project.',
        'case_study' => 'Studi kasus project.',
        'solution' => 'Solusi project.',
        'features' => ['Fitur pertama'],
        'technologies' => ['Laravel'],
        'github_url' => 'https://github.com/sandev/sistem-baru',
        'demo_url' => '',
        'status' => true,
        'sort_order' => 7,
    ])->assertRedirect(route('admin.projects.index'));

    $this->assertDatabaseHas('projects', [
        'slug' => 'sistem-baru',
        'title' => 'Sistem Baru',
        'status' => true,
        'sort_order' => 7,
    ]);
});

it('generates the slug from the title when slug is empty', function () {
    $this->post(route('admin.projects.store'), [
        'title' => 'Sistem Informasi Baru',
        'slug' => '',
        'summary' => 'Ringkasan.',
        'case_study' => 'Studi kasus.',
        'solution' => 'Solusi.',
        'features' => ['Fitur'],
        'technologies' => ['Laravel'],
        'status' => false,
        'sort_order' => 1,
    ]);

    $this->assertDatabaseHas('projects', ['slug' => 'sistem-informasi-baru']);
});

it('validates required fields with indonesian messages', function () {
    $this->post(route('admin.projects.store'), [
        'title' => '',
        'summary' => '',
        'case_study' => '',
        'solution' => '',
        'features' => [''],
        'technologies' => [],
        'sort_order' => 1,
    ])->assertSessionHasErrors([
        'title' => 'Judul wajib diisi.',
        'summary' => 'Ringkasan wajib diisi.',
        'case_study' => 'Studi kasus wajib diisi.',
        'solution' => 'Solusi wajib diisi.',
        'features' => 'Minimal satu fitur.',
        'technologies' => 'Minimal satu teknologi.',
    ]);
});

it('rejects a duplicate slug', function () {
    Project::factory()->create(['slug' => 'sikasir']);

    $this->post(route('admin.projects.store'), [
        'title' => 'SIKASIR',
        'slug' => 'sikasir',
        'summary' => 'Ringkasan.',
        'case_study' => 'Studi kasus.',
        'solution' => 'Solusi.',
        'features' => ['Fitur'],
        'technologies' => ['Laravel'],
        'status' => false,
        'sort_order' => 1,
    ])->assertSessionHasErrors(['slug' => 'Slug sudah digunakan.']);
});

it('stores an uploaded thumbnail on the public disk', function () {
    Storage::fake('public');

    $this->post(route('admin.projects.store'), [
        'title' => 'Dengan Thumbnail',
        'slug' => 'dengan-thumbnail',
        'summary' => 'Ringkasan.',
        'case_study' => 'Studi kasus.',
        'solution' => 'Solusi.',
        'features' => ['Fitur'],
        'technologies' => ['Laravel'],
        'status' => false,
        'sort_order' => 1,
        'thumbnail' => UploadedFile::fake()->image('thumb.png', 640, 400),
    ])->assertRedirect(route('admin.projects.index'));

    $project = Project::query()->where('slug', 'dengan-thumbnail')->firstOrFail();

    expect($project->thumbnail)->toStartWith('projects/');
    Storage::disk('public')->assertExists($project->thumbnail);
});

it('updates an existing project', function () {
    $project = Project::factory()->create(['slug' => 'lama']);

    $this->put(route('admin.projects.update', $project), [
        'title' => 'Judul Baru',
        'slug' => 'baru',
        'summary' => 'Ringkasan baru.',
        'case_study' => 'Studi kasus baru.',
        'solution' => 'Solusi baru.',
        'features' => ['Fitur baru'],
        'technologies' => ['Laravel', 'Vue.js'],
        'status' => true,
        'sort_order' => 3,
    ])->assertRedirect(route('admin.projects.index'));

    $this->assertDatabaseHas('projects', [
        'id' => $project->id,
        'title' => 'Judul Baru',
        'slug' => 'baru',
        'status' => true,
    ]);
});

it('allows a project to keep its own slug on update', function () {
    $project = Project::factory()->create(['slug' => 'tetap']);

    $this->put(route('admin.projects.update', $project), [
        'title' => $project->title,
        'slug' => 'tetap',
        'summary' => $project->summary,
        'case_study' => $project->case_study,
        'solution' => $project->solution,
        'features' => $project->features,
        'technologies' => $project->technologies,
        'status' => $project->status,
        'sort_order' => $project->sort_order,
    ])->assertSessionDoesntHaveErrors()->assertRedirect(route('admin.projects.index'));
});

it('toggles the publish status', function () {
    $project = Project::factory()->create();

    $this->patch(route('admin.projects.toggle-status', $project));

    expect($project->refresh()->status)->toBeTrue();

    $this->patch(route('admin.projects.toggle-status', $project));

    expect($project->refresh()->status)->toBeFalse();
});

it('soft deletes a project and flashes an undo id', function () {
    $project = Project::factory()->create();

    $this->delete(route('admin.projects.destroy', $project))
        ->assertRedirect(route('admin.projects.index'))
        ->assertSessionHas('undoId', $project->id);

    $this->assertSoftDeleted('projects', ['id' => $project->id]);
});

it('restores a soft deleted project', function () {
    $project = Project::factory()->create();
    $project->delete();

    $this->post(route('admin.projects.restore', ['id' => $project->id]))
        ->assertRedirect(route('admin.projects.index'));

    $this->assertNotSoftDeleted('projects', ['id' => $project->id]);
});

it('hides soft deleted projects from the landing page', function () {
    $project = Project::factory()->published()->create();
    $project->delete();

    $this->get(route('home'))
        ->assertInertia(fn ($page) => $page->has('projects', 0));
});
