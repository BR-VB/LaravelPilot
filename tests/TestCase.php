<?php

namespace Tests;

use App\Models\User;
use Database\Seeders\ProjectSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use RefreshDatabase;

    protected function setUpInit(string $locale = 'en'): void
    {
        //intialize locale
        app()->setLocale($locale);

        //initialize with 1 featured project and 1 not featured project
        $this->seed(ProjectSeeder::class);
    }

    protected function addNormalUser(): User
    {
        //create a normal user
        return User::factory()->create();
    }

    protected function addAdminUser(): User
    {
        //create an admin user
        return User::factory()->create([
            'is_admin' => true,
        ]);
    }
}
