<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->unique()->words(2, true);

        return [
            'title' => Str::title($title),
            'slug' => Str::slug($title),
            'thumbnail' => null,
            'summary' => fake()->sentence(12),
            'case_study' => fake()->paragraph(),
            'solution' => fake()->paragraph(),
            'features' => fake()->sentences(4),
            'technologies' => fake()->randomElements(
                ['Laravel', 'PHP', 'MySQL', 'Tailwind CSS', 'Alpine.js', 'Livewire', 'Vue.js'],
                3,
            ),
            'screenshots' => [],
            'github_url' => null,
            'demo_url' => null,
            'status' => false,
            'sort_order' => fake()->numberBetween(1, 20),
        ];
    }

    /**
     * Indicate that the project is published on the landing page.
     */
    public function published(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => true,
        ]);
    }
}
