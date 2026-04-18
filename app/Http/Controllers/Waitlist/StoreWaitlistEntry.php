<?php

namespace App\Http\Controllers\Waitlist;

use App\Mail\AdminWaitlistSignupMail;
use App\Mail\WaitlistConfirmationMail;
use App\Models\WaitlistEntry;
use Illuminate\Contracts\Mail\Factory;

class StoreWaitlistEntry
{
    public function __construct(private Factory $mail)
    {
    }

    public function handle(string $email): WaitlistEntry
    {
        $waitlistEntry = WaitlistEntry::query()->createOrFirst([
            'email' => $email,
        ]);

        if ($waitlistEntry->wasRecentlyCreated) {
            $this->queueNotifications($waitlistEntry);
        }

        return $waitlistEntry;
    }

    private function queueNotifications(WaitlistEntry $waitlistEntry): void
    {
        $adminAddress = config('waitlist.notify.address');

        if (filled($adminAddress)) {
            $this->mail
                ->to($adminAddress)
                ->queue((new AdminWaitlistSignupMail($waitlistEntry))->afterCommit());
        }

        $this->mail
            ->to($waitlistEntry->email)
            ->queue((new WaitlistConfirmationMail($waitlistEntry))->afterCommit());
    }
}
