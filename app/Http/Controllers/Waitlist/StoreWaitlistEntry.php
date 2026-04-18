<?php

namespace App\Http\Controllers\Waitlist;

use App\Mail\AdminWaitlistSignupMail;
use App\Mail\WaitlistConfirmationMail;
use App\Models\WaitlistEntry;
use Illuminate\Contracts\Mail\Factory;

class StoreWaitlistEntry
{
    public function __construct(private Factory $mail) {}

    public function handle(string $email): WaitlistEntry
    {
        $waitlistEntry = WaitlistEntry::query()->createOrFirst([
            'email' => $email,
        ]);

        if ($waitlistEntry->wasRecentlyCreated) {
            $this->sendNotifications($waitlistEntry);
        }

        return $waitlistEntry;
    }

    private function sendNotifications(WaitlistEntry $waitlistEntry): void
    {
        $adminAddress = config('waitlist.notify.address');

        if (filled($adminAddress)) {
            $this->mail
                ->to($adminAddress)
                ->send(new AdminWaitlistSignupMail($waitlistEntry));
        }

        $this->mail
            ->to($waitlistEntry->email)
            ->send(new WaitlistConfirmationMail($waitlistEntry));
    }
}
