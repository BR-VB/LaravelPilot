<?php

namespace App\Listeners;

use App\Events\TranslationMissing;
use App\Mail\TranslationMissingMail;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class NotifyTranslationMissing
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(TranslationMissing $event): void
    {
        $user = $event->user;
        $project = $event->project;

        $emailDetails = [
            'projectTitle' => $project->title,
            'projectId' => $project->id,
            'reportingUser' => $user->name,
            'reportingUserEmail' => $user->email,
        ];

        $usersToSendEmailTo = User::where('is_admin', true)->get();

        $usersToSendEmailTo->each(function ($toUser) use ($emailDetails) {
            Mail::to($toUser)->send(new TranslationMissingMail($emailDetails));
        });

        Log::info(class_basename(self::class), [__FUNCTION__ => [$user->id, $project->id]]);
    }
}
