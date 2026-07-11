<?php

use App\Models\Project;

it('renders the home page with published projects only', function () {
    $published = Project::factory()->published()->create(['title' => 'SIKASIR']);
    Project::factory()->create(['title' => 'Draft Project']);

    $this->get(route('home'))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('public/Home')
            ->has('projects', 1)
            ->where('projects.0.title', $published->title));
});

it('orders home page projects by sort order', function () {
    Project::factory()->published()->create(['title' => 'Second', 'sort_order' => 2]);
    Project::factory()->published()->create(['title' => 'First', 'sort_order' => 1]);

    $this->get(route('home'))
        ->assertInertia(fn ($page) => $page
            ->where('projects.0.title', 'First')
            ->where('projects.1.title', 'Second'));
});

it('renders a published project detail page by slug', function () {
    $project = Project::factory()->published()->create();

    $this->get(route('project.show', $project))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('public/ProjectDetail')
            ->where('project.slug', $project->slug)
            ->where('project.title', $project->title));
});

it('returns 404 for a draft project detail page', function () {
    $project = Project::factory()->create();

    $this->get(route('project.show', $project))->assertNotFound();
});

it('returns 404 for an unknown project slug', function () {
    $this->get('/project/tidak-ada')->assertNotFound();
});
