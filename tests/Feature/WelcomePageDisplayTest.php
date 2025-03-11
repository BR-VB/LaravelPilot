<?php

namespace Tests\Feature;

use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WelcomePageDisplayTest extends TestCase
{
    use RefreshDatabase;

    public function test_welcome_page_with_empty_db_returns_an_error_and_message_en(): void
    {
        //given
        app()->setLocale('en');

        //when
        $response = $this->get(route('home'));

        //then
        $response->assertStatus(500)
            ->assertJson([
                'error' => __('middleware.featured_project_error'),
            ]);
    }

    public function test_welcome_page_with_empty_db_returns_an_error_and_message_de(): void
    {
        app()->setLocale('de');

        $response = $this->get(route('home'));

        $response->assertStatus(500)
            ->assertJson([
                'error' => __('middleware.featured_project_error'),
            ]);
    }

    public function test_welcome_page_with_1_project_but_not_featured_returns_an_error_and_message(): void
    {
        app()->setLocale('en');

        Project::factory()->create();

        $response = $this->get(route('home'));

        $response->assertStatus(500)
            ->assertJson([
                'error' => __('middleware.featured_project_error'),
            ]);
    }

    public function test_welcome_page_with_1_project_featured_returns_a_success_status(): void
    {
        app()->setLocale('en');

        $project = Project::factory()->create([
            'is_featured' => true,
        ]);

        $response = $this->get(route('home'));

        $response->assertStatus(200);

        $this->assertDatabaseHas('projects', [
            'id' => $project->id,
            'title' => $project->title,
            'description' => $project->description,
            'is_featured' => true,
        ]);
    }
}
