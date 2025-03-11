<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;

class ProjectPolicy
{
    /**
     * Determine whether the user is allowed to report on projects
     */
    public function report(User $user, Project $project): bool
    {
        return ! $user->is_admin && $user->is_reporting && $project->is_featured;
    }
}
